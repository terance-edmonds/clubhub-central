<?php

class Password extends Controller
{
    public function index()
    {
        $data = [
            "errors" => []
        ];

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $user = new User();
            $user_password_token = new UserPasswordToken();
            $mail = new Mail();

            try {
                $form_data = $_POST;
                $exists = $user->one(["email" => $form_data['email']]);

                if (empty($exists)) {
                    $data['errors']['email'] = "No user with the given email exists";
                } else if ($user_password_token->validateCreate($form_data)) {
                    $token = md5(uniqid(rand(), true));

                    $user_password_token->create([
                        "user_id" => $exists->id,
                        "token" => $token,
                        "email" => $form_data['email'],
                        "created_datetime" => date("Y-m-d H:i:s")
                    ]);

                    $mail->send([
                        "to" => [
                            "mail" => $form_data['email']
                        ],
                        "subject" => "Password Reset",
                        "body" => $mail->template("forgot-password", [
                            "from_email" => MAIL_USER,
                            "from_name" => MAIL_USERNAME,
                            "reset_password_link" => ROOT . "/password/reset"  . "?token=" . $token
                        ])
                    ]);

                    $_SESSION['alerts'] = [["status" => "success", "message" => "Please check you mailbox for the reset link."]];
                } else {
                    $data['errors'] = $user_password_token->errors;
                }
            } catch (Throwable $th) {
                show($th);
                $_SESSION['alerts'] = [["status" => "error", "message" => "Failed to send password reset link, please try again later."]];
            }
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && count($data['errors']) == 0) return redirect('login');

        $this->view("password", $data);
    }

    public function reset()
    {
        $data = [
            "errors" => []
        ];

        if (empty($_GET['token'])) {
            return redirect('login');
        }

        $redirect_link = 'login';
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $db = new Database();
            $user = new User($db);
            $user_password_token = new UserPasswordToken($db);

            $db->transaction();

            try {
                $form_data = $_POST;
                $form_data['token'] = $_GET['token'];
                $valid_token = $user_password_token->one(["token" => $form_data['token'], "is_used" => 0]);

                if (empty($valid_token) or $valid_token->is_used) {
                    $_SESSION['alerts'] = [["status" => "error", "message" => "Your reset link has been expired."]];
                    $redirect_link  = 'password/reset?token' . $form_data['token'];
                } else {
                    $date1 = new DateTime($valid_token->created_datetime);
                    $date2 = new DateTime();

                    $interval = $date1->diff($date2);
                    $minutes = $interval->days * 24 * 60;
                    $minutes += $interval->h * 60;
                    $minutes += $interval->i;


                    if ($minutes > 15) {
                        $_SESSION['alerts'] = [["status" => "error", "message" => "Your reset link has been expired."]];
                        $redirect_link  = 'password/reset?token' . $form_data['token'];

                        /* set the token as used */
                        $user_password_token->update(["id" => $valid_token->id], [
                            "is_used" => 1
                        ]);
                    } else if ($user->validateResetPassword($form_data)) {
                        /* reset the password */
                        $pass = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
                        $user->update(["id" => $valid_token->user_id], ["password" => $pass]);

                        /* set the token as used */
                        $user_password_token->update(["id" => $valid_token->id], [
                            "is_used" => 1
                        ]);

                        $_SESSION['alerts'] = [["status" => "success", "message" => "Password has been reset successfully"]];
                    }

                    $data['errors'] = $user->errors;
                }

                $db->commit();
            } catch (Throwable $th) {
                $db->rollback();
                $_SESSION['alerts'] = [["status" => "error", "message" => "Failed to reset password, please try again later."]];
            }
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && count($data['errors']) == 0) return redirect($redirect_link);

        $this->view("password/reset", $data);
    }
}
