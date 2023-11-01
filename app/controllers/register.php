<?php

class Register extends Controller
{

    public function index()
    {
        $data = [
            "errors" => []
        ];

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $user_data = $_POST;

            $db = new Database();
            $user = new User($db);
            $user_invitation = new UserInvitation($db);

            if ($user->validateRegister($user_data)) {
                try {
                    $db->transaction();

                    $user_data['password'] = password_hash($user_data['password'], PASSWORD_DEFAULT);
                    $result = $user->create($user_data, "email");

                    if (!empty($result)) {
                        $mail = new Mail();
                        $token = randomString();

                        $user_invitation->create([
                            "user_id" => $result->id,
                            "invitation_code" => $token,
                            "is_valid" => 1
                        ]);

                        /* send verification mail */
                        $mail->send([
                            "to" => [
                                "mail" => $user_data['email'],
                                "name" => $user_data['first_name'] . " " . $user_data['last_name'],
                            ],
                            "subject" => "Email Verification",
                            "body" => $mail->template("email-verification", [
                                "from_email" => MAIL_USER,
                                "from_name" => MAIL_USERNAME,
                                "verification_link" => ROOT . "/register/verify?token=" . $token
                            ])
                        ]);

                        $db->commit();

                        redirect('login');
                    } else {
                        $data["errors"]["email"] = "Something went wrong!";
                    }
                } catch (Throwable $th) {
                    $data['errors'] = "Failed to register user, please try again later.";
                    $db->rollback();
                }
            }

            $data['errors'] = $user->errors;
        }

        $this->view("register", $data);
    }

    public function verify()
    {
        $data = [
            "is_verified" => False
        ];

        $db = new Database();
        $user = new User($db);
        $user_invitation = new UserInvitation($db);
        $token = $_GET["token"];

        try {
            $result = $user_invitation->one(["invitation_code" => $token, "is_valid" => 1]);

            if (!empty($result)) {
                $db->transaction();

                $user->update(["id" => $result->user_id], ["is_verified" => 1]);
                $user_invitation->update(["id" => $result->id], ["is_valid" => 0]);

                $db->commit();

                $data["is_verified"] = True;
            }
        } catch (Throwable $th) {
            $data['errors'] = "Failed to register user, please try again later.";
            $db->rollback();
        }

        $this->view("register/verify", $data);
    }
}
