<?php

class Register extends Controller
{

    public function index()
    {
        $data = [
            "errors" => []
        ];

        $redirect_link = null;

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $user_data = $_POST;
            $params = $_GET;

            $db = new Database();
            $user = new User($db);
            $user_invitation = new UserInvitation($db);

            if ($user->validateRegister($user_data)) {
                $db->transaction();
                try {

                    $user_data['password'] = password_hash($user_data['password'], PASSWORD_DEFAULT);
                    $result = $user->create($user_data, "email");

                    if (!empty($result)) {
                        $mail = new Mail();
                        $token = randomString();

                        if (!empty($params) && !empty($params['token'])) {
                            $token = $params['token'];
                            $user_invitation->update(["invitation_code" => $token], ["user_id" => $result->id]);
                        } else {
                            $user_invitation->create([
                                "user_id" => $result->id,
                                "invitation_code" => $token,
                                "is_valid" => 1
                            ]);
                        }

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

                        $_SESSION['alerts'] = [["status" => "success", "message" => "A verification mail is sent to your email please check your inbox."]];
                        $redirect_link = 'login';
                    } else {
                        $data["errors"]["email"] = "Something went wrong!";
                    }
                } catch (Throwable $th) {
                    $data['errors'] = ["error" => "Failed"];
                    $_SESSION['alerts'] = [["status" => "error", "message" => "Failed to register user. Please try again later."]];
                    $db->rollback();
                }
            }

            $data['errors'] = $user->errors;
        }

        if ($_SERVER['REQUEST_METHOD'] == "POST" && count($data['errors']) == 0) return redirect($redirect_link);

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
        $club_member = new ClubMember($db);
        $club = new Clubs($db);
        $mail = new Mail();

        $token = $_GET["token"];

        try {
            $db->transaction();
            $result = $user_invitation->one(["invitation_code" => $token, "is_valid" => 1]);

            if (!empty($result)) {
                $user_data = $user->one(["id" => $result->user_id]);

                /* update user state and invitation states */
                $user->update(["id" => $result->user_id], ["is_verified" => 1]);
                $user_invitation->update(["id" => $result->id], ["is_valid" => 0]);

                /* create club member record */
                if ($result->club_role && $result->club_id) {
                    $club_member_data = [
                        "user_id" => $result->user_id,
                        "club_id" => $result->club_id,
                        "role" => $result->club_role,
                        "state" => "ACCEPTED"
                    ];

                    $club->update(["id" => $result->club_id], ["state" => "ACTIVE"]);
                    $club_member->create($club_member_data);
                }

                $data["is_verified"] = True;

                /* send registered mail */
                $mail->send([
                    "to" => [
                        "mail" => $user_data->email,
                        "name" => $user_data->first_name . " " . $user_data->last_name,
                    ],
                    "subject" => "Email Verification",
                    "body" => $mail->template("user-registered", [
                        "from_email" => MAIL_USER,
                        "from_name" => MAIL_USERNAME,
                        "clubhub_central_link" => ROOT
                    ])
                ]);
            }

            $db->commit();
        } catch (Throwable $th) {
            // show($th);
            $_SESSION['alerts'] = [["status" => "error", "message" => "Failed to register user, please try again later."]];
            $db->rollback();
        }

        $this->view("register/verify", $data);
    }
}
