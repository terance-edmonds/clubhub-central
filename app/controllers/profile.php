<?php

class Profile extends Controller
{
    public function index()
    {
        $left_bar = [
            "calendar_data" => [
                "current_path" => "/"
            ]
        ];
        $right_bar = [
            "clubs" => [],
            "menu" => [
                ["id" => "profile", "name" => "Profile Details", "icon" => "info", "path" => "/profile/edit"],
                ["id" => "system", "name" => "Manage System", "icon" => "dashboard", "path" => "/admin/dashboard"]

            ]
        ];

        $data = [
            "tab" => "gallery",
            "left_bar" => $left_bar,
            "right_bar" => $right_bar,
        ];
        $params = $_GET;

        if (isset($params["tab"])) $data["tab"] = $params["tab"];

        $this->view("profile", $data);
    }

    public function edit()
    {
        $user = new User();
        $auth_user = Auth::user();

        $left_bar = [
            "calendar_data" => [
                "current_path" => "/"
            ]
        ];
        $data = [
            "left_bar" => $left_bar,
            "alerts" => [],
            "errors" => []
        ];

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            /* update profile details */
            if ($_POST['submit'] === 'update_profile') {
                $_POST['id'] = $auth_user['id'];
                $image_uploaded = true;
                $update_data = ["first_name" => $_POST['first_name'], "last_name" => $_POST['last_name'], "email" => $_POST['email']];

                if (!empty($_FILES['image']['name'])) {
                    $file_upload = uploadFile('image');

                    if (empty($file_upload)) {

                        $image_uploaded = false;
                        $data["errors"]["image"] = "Failed to upload the image, please try again later";
                    } else {
                        $update_data['image'] = $file_upload['url'];
                    }
                }

                if ($image_uploaded && $user->validateUpdate($_POST)) {
                    $user->update(["id" => $auth_user["id"]], $update_data);

                    $_SESSION['alerts'] = [["status" => "success", "message" => "Profile data updated successfully"]];

                    redirect();
                }
            } else if ($_POST['submit'] === 'change_password') {
                /* change password */
                if ($user->validateChangePassword($_POST)) {
                    $pass = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

                    $user->update(["id" => $auth_user["id"]], ["password" => $pass]);
                    $_POST = array();

                    redirect();
                }
            }
        }

        /* fetch data and fill the form */
        $this->setUserDetails($user, $auth_user);
        $data['errors'] = $user->errors;

        $this->view("profile/edit", $data);
    }

    private function setUserDetails($user, $auth_user)
    {
        if (!empty($auth_user)) {
            $result = $user->one(['id' => $auth_user["id"]]);

            if ($result->first_name) $_POST['first_name'] = $result->first_name;
            if ($result->last_name) $_POST['last_name'] = $result->last_name;
            if ($result->email) $_POST['email'] = $result->email;
            if ($result->image) $_POST['image'] = $result->image;
        }
    }
}
