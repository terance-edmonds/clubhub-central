<?php

class Login extends Controller
{
    public function index()
    {

        $data = [
            "errors" => []
        ];

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $user = new User();
            $result = $user->one(['email' => $_POST['email']]);

            if ($result) {
                if (!$result->is_verified) {
                    $data['errors']['email'] = "User account not verified";
                } else if ($result->is_blacklisted) {
                    $data['errors']['email'] = "User account has been suspended";
                } else if (password_verify($_POST['password'], $result->password)) {
                    Auth::authenticate([
                        "id" => $result->id,
                        "first_name" => $result->first_name,
                        "last_name" => $result->last_name,
                        "role" => $result->role,
                    ]);

                    redirect('home');
                } else {
                    $data['errors']['password'] = "Incorrect password";
                }
            } else {
                $data['errors']['email'] = "User not found";
            }
        }

        $this->view("login", $data);
    }
}
