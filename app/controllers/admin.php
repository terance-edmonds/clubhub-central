<?php

class Admin extends Controller
{
    public function index()
    {

        $this->view("admin");
    }

    public function dashboard()
    {
        $path = $_GET["url"];
        $func = "view";

        /* use outlined icons */
        $menu = [
            ["id" => "clubs", "name" => "Clubs", "icon" => "info", "path" => ["/admin/dashboard", "/admin/dashboard/club/add"], "active" => "false"],
            ["id" => "events", "name" => "Events", "icon" => "app_registration", "path" => "/admin/dashboard/events", "active" => "false"],
            ["id" => "requests", "name" => "Requests", "icon" => "diversity_3", "path" => "/admin/dashboard/requests", "active" => "false"],
            ["id" => "users", "name" => "Users", "icon" => "people", "path" => "/admin/dashboard/users", "active" => "false"],
        ];
        $func = getActiveMenu($menu, $path);

        $data = [
            "menu" => $menu,
            "errors" => []
        ];

        $this->$func($path, $data);
    }


    public function clubs($path, $data)
    {
        $db = new Database();
        $club = new Clubs($db);
        $user = new User($db);
        $user_invitation = new UserInvitation($db);
        $mail = new Mail();
        $redirect_link = null;

        try {
            $db->transaction();
            if ($_SERVER['REQUEST_METHOD'] == "POST") {

                $form_data = $_POST;
                $link_path = "register";

                if ($club->validateCreateClub($form_data)) {
                    $user_invitation_data = [
                        "club_role" => "CLUB_IN_CHARGE",
                        "invitation_code" => randomString(),
                        "is_valid" => 1,
                        "club_id" => "",
                    ];
                    $user_exists = $user->one(["email" => $form_data['club_in_charge_email']]);

                    if (!empty($user_exists)) {
                        $link_path = "login";
                        $user_invitation_data["user_id"] = $user_exists->id;
                    }

                    /* create club record */
                    $club_result = $club->create($form_data);
                    if (!empty($club_result)) {
                        $user_invitation_data["club_id"] = $club_result->id;
                    }

                    /* create a user invitation */
                    $user_invitation->create($user_invitation_data);

                    $mail->send([
                        "to" => [
                            "mail" => $form_data['club_in_charge_email']
                        ],
                        "subject" => "You Are Invited As Club In Charge",
                        "body" => $mail->template("club-invitation", [
                            "from_email" => MAIL_USER,
                            "from_name" => MAIL_USERNAME,
                            "club_name" => $form_data["name"],
                            "invitation_link" => ROOT . "/" . $link_path . "?token=" . $user_invitation_data["invitation_code"]
                        ])
                    ]);

                    $_SESSION['alerts'] = [["status" => "success", "message" => "Club account created and club in charge email sent successfully"]];
                    $redirect_link = "admin/dashboard";
                }
                //var_dump($club->errors);
                $data['errors'] = $club->errors;
            }

            /* fetch results */
            $data["table_data"] = $club->find(["is_deleted" => 0]);

            $db->commit();
        } catch (\Throwable $th) {
            //var_dump($th);
            $_SESSION['alerts'] = [["status" => "error", "message" => "Failed to process the action, please try again later."]];
            $db->rollback();
        }

        if ($_SERVER['REQUEST_METHOD'] == "POST" &&  count($data['errors']) == 0) return redirect($redirect_link);

        $this->view($path, $data);
    }

    public function events($path, $data)
    {
        $this->view($path, $data);
    }

    public function requests($path, $data)
    {
        $this->view($path, $data);
    }

    public function users($path, $data)
    {
        $this->view($path, $data);
    }
}
