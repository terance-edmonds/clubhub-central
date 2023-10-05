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

            if ($user->validate($user_data)) {
                try {
                    $db->transaction();

                    $user_data['password'] = password_hash($user_data['password'], PASSWORD_DEFAULT);
                    $result = $user->create($user_data, "email");

                    if (!empty($result)) {
                        $user_invitation->create([
                            "user_id" => $result->id,
                            "invitation_code" => randomString(),
                            "is_valid" => true
                        ]);
                        var_dump("1");
                        $db->commit();
                        var_dump("2");

                        redirect('login');
                    } else {
                        $data["errors"]["email"] = "Something went wrong!";
                    }
                } catch (Throwable $th) {
                    var_dump($th);
                    $db->rollback();
                }
            }

            $data['errors'] = $user->errors;
        }

        $this->view("register", $data);
    }

    public function verify()
    {
        $this->view("register/verify");
    }
}
