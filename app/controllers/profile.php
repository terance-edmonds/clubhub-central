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
            ]
        ];

        /* if super admin add the menu item */
        $auth_user = Auth::user();
        if ($auth_user['role'] == 'SUPER_ADMIN') {
            array_push($right_bar["menu"], ["id" => "system", "name" => "Manage System", "icon" => "dashboard", "path" => "/admin/dashboard"]);
        }

        /* fetch clubs */
        $member_clubs = new ClubMember();
        $right_bar["clubs"] = $member_clubs->find(
            ["club_members.user_id" => $auth_user['id'], "club_members.state" => "ACCEPTED"],
            ["club_members.id as club_member_id", "role as club_role", "club.id as club_id", "club.name as club_name", "club.image as club_image"],
            [
                ["table" => "clubs", "as" => "club", "on" => "club_members.club_id = club.id"]
            ]
        );

        $menu_side_bar = array_merge($left_bar, $right_bar);

        /* set data */
        $data = [
            "tab" => "gallery",
            "left_bar" => $left_bar,
            "right_bar" => $right_bar,
            "gallery" => [],
            "menu_side_bar" => $menu_side_bar
        ];
        $params = $_GET;
        if (isset($params["tab"]))
            $data["tab"] = $params["tab"];

        /* post requests */
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            /* logout */
            if ($_POST['submit'] == 'logout') {
                Auth::logout();

                return redirect('login');
            } else if ($_POST['submit'] == 'club-redirect') {
                /* club redirect */
                $storage = new Storage();

                $storage->set('club_id', $_POST['club_id']);
                $storage->set('club_role', $_POST['club_role']);
                $storage->set('club_member_id', $_POST['club_member_id']);

                return redirect('club/dashboard');
            } else if ($_POST['submit'] == 'upload-image') {
                if (!empty($_FILES['image']['name'])) {
                    $user_gallery = new UserGallery();
                    $file_upload = uploadFile('image');

                    $user_gallery->create([
                        "user_id" => $auth_user['id'],
                        "image" => $file_upload['url']
                    ]);
                } else {
                    $_SESSION['alerts'] = [["status" => "error", "message" => "Failed to upload the image, please try again later"]];
                }

                return redirect();
            } else if ($_POST['submit'] == 'delete-image') {
                $user_gallery = new UserGallery();
                $user_gallery->delete([
                    "id" => $_POST['id']
                ]);

                return redirect();
            }
        }

        if ($data['tab'] == 'club-posts') {
            $post = new ClubPost();
            $posts_data = $post->find(
                ["club_posts.is_deleted" => 0, "club_posts.user_id" => $auth_user['id']],
                [
                    "club_posts.id",
                    "club_posts.post_name",
                    "club_posts.description",
                    "club_posts.image",
                    "club_posts.created_datetime",
                    "user.first_name",
                    "user.last_name",
                    "club.id as club_id",
                    "club.name as club_name",
                    "club.image as club_image",
                ],
                [
                    ["table" => "users", "as" => "user", "on" => "club_posts.user_id = user.id"],
                    ["table" => "clubs", "as" => "club", "on" => "club_posts.club_id = club.id"]
                ],
            );

            $data['posts'] = $posts_data;
        } else {
            $user_gallery = new UserGallery();
            $data['gallery'] = $user_gallery->find(["user_id" => $auth_user['id']]);
        }

        $this->view("profile", $data);
    }

    public function public()
    {
        $params = $_GET;
        $user = new User();

        if (!isset($params["id"])) return redirect('not-found');

        $user = $user->one(["id" => $params['id']]);
        if (empty($user)) return redirect('not-found');

        $left_bar = [
            "user" => $user,
            "calendar_data" => [
                "current_path" => "/"
            ]
        ];
        $right_bar = [
            "clubs" => [],
            "menu" => [
                ["id" => "profile", "name" => "Profile Details", "icon" => "info", "path" => "/profile/edit"],
            ]
        ];

        /* if super admin add the menu item */
        $auth_user = Auth::user();
        if ($auth_user['role'] == 'SUPER_ADMIN') {
            array_push($right_bar["menu"], ["id" => "system", "name" => "Manage System", "icon" => "dashboard", "path" => "/admin/dashboard"]);
        }

        /* fetch clubs */
        $member_clubs = new ClubMember();
        $right_bar["clubs"] = $member_clubs->find(
            ["club_members.user_id" => $auth_user['id'], "club_members.state" => "ACCEPTED"],
            ["club_members.id as club_member_id", "role as club_role", "club.id as club_id", "club.name as club_name", "club.image as club_image"],
            [
                ["table" => "clubs", "as" => "club", "on" => "club_members.club_id = club.id"]
            ]
        );

        $menu_side_bar = array_merge($left_bar, $right_bar);

        /* set data */
        $data = [
            "tab" => "gallery",
            "left_bar" => $left_bar,
            "right_bar" => $right_bar,
            "gallery" => [],
            "menu_side_bar" => $menu_side_bar
        ];

        if (isset($params["tab"]))
            $data["tab"] = $params["tab"];

        if ($data['tab'] == 'club-posts') {
            $post = new ClubPost();
            $posts_data = $post->find(
                ["club_posts.is_deleted" => 0, "club_posts.user_id" => $params['id']],
                [
                    "club_posts.id",
                    "club_posts.post_name",
                    "club_posts.description",
                    "club_posts.image",
                    "club_posts.created_datetime",
                    "user.first_name",
                    "user.last_name",
                    "club.id as club_id",
                    "club.name as club_name",
                    "club.image as club_image",
                ],
                [
                    ["table" => "users", "as" => "user", "on" => "club_posts.user_id = user.id"],
                    ["table" => "clubs", "as" => "club", "on" => "club_posts.club_id = club.id"]
                ],
            );

            $data['posts'] = $posts_data;
        } else {
            $user_gallery = new UserGallery();
            $data['gallery'] = $user_gallery->find(["user_id" => $auth_user['id']]);
        }

        $this->view("profile/public", $data);
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
            if ($_POST['submit'] == 'update_profile') {
                $_POST['id'] = $auth_user['id'];
                $image_uploaded = true;
                $update_data = $_POST;

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
                }
            } else if ($_POST['submit'] === 'change_password') {
                /* change password */
                if ($user->validateChangePassword($_POST)) {
                    $pass = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

                    $user->update(["id" => $auth_user["id"]], ["password" => $pass]);
                    $_POST = array();
                }
            }

            $data['errors'] = $user->errors;

            if (count($data['errors']) == 0)
                return redirect();
        }

        /* fetch data and fill the form */
        $this->setUserDetails($user, $auth_user);

        $this->view("profile/edit", $data);
    }

    private function setUserDetails($user, $auth_user)
    {
        if (!empty($auth_user)) {
            $result = $user->one(['id' => $auth_user["id"]]);

            if ($result->first_name)
                $_POST['first_name'] = $result->first_name;
            if ($result->last_name)
                $_POST['last_name'] = $result->last_name;
            if ($result->email)
                $_POST['email'] = $result->email;
            if ($result->image)
                $_POST['image'] = $result->image;
            if ($result->description)
                $_POST['description'] = $result->description;
        }
    }
}
