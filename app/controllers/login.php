<?php

class Login extends Controller
{
    public function index()
    {
        $data = [
            "errors" => []
        ];

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $db = new Database();
            $user = new User($db);
            $user_invitation = new UserInvitation($db);
            $club_member = new ClubMember($db);
            $club = new Clubs($db);
            $success = false;

            $db->transaction();

            try {
                $result = $user->one(['email' => $_POST['email']]);

                if ($result) {
                    if (!$result->is_verified) {
                        $data['errors']['email'] = "User account not verified";
                    } else if ($result->is_blacklisted) {
                        $data['errors']['email'] = "User account has been suspended";
                    } else if (password_verify($_POST['password'], $result->password)) {
                        $params = $_GET;
                        $success = true;

                        if (!empty($params) && !empty($params['token'])) {
                            $invitation_result = $user_invitation->one(["invitation_code" => $params['token'], "is_valid" => 1]);

                            if (!empty($invitation_result) && $invitation_result->user_id == $result->id) {
                                $user_invitation->update(["id" => $invitation_result->id], ["is_valid" => 0]);

                                /* create club member record */
                                if ($invitation_result->club_role && $invitation_result->club_id) {
                                    $club_member_data = [
                                        "user_id" => $invitation_result->user_id,
                                        "club_id" => $invitation_result->club_id,
                                        "role" => $invitation_result->club_role,
                                        "state" => "ACCEPTED"
                                    ];

                                    $club->update(["id" => $invitation_result->club_id], ["state" => "ACTIVE"]);
                                    $club_member->create($club_member_data);
                                }
                            } else {
                                $success = false;
                                $_SESSION['alerts'] = [["status" => "error", "message" => "Failed to login, invalid token or token has expired."]];
                            }
                        }
                    } else {
                        $data['errors']['password'] = "Incorrect password";
                    }
                } else {
                    $data['errors']['email'] = "User not found";
                }

                $db->commit();

                if ($success) {
                    Auth::set([
                        "id" => $result->id,
                        "first_name" => $result->first_name,
                        "last_name" => $result->last_name,
                        "role" => $result->role,
                    ]);

                    return redirect('home');
                }
            } catch (Throwable $th) {
                $_SESSION['alerts'] = [["status" => "error", "message" => "Failed to login, please try again later."]];
                $db->rollback();
            }
        }

        if($_SERVER['REQUEST_METHOD'] == 'POST' && count($data['errors']) == 0) return redirect('login');

        $this->view("login", $data);
    }
}
