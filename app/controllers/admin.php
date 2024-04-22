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
        $notification = new UserNotifications($db);
        $notification_state = new UserNotificationsState($db);

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

                    /* set notification */
                    $notification_result = $notification->create([
                        "title" => $form_data['name']  . ' Club',
                        "description" => '"' . $form_data['name'] . '" is inviting you to be the club in charge. Please check your mail box for the invitation.',
                    ]);

                    $notification_state->create([
                        "user_id" => $user_invitation_data["user_id"],
                        "notification_id" => $notification_result->id,
                    ]);

                    $_SESSION['alerts'] = [["status" => "success", "message" => "Club account created and club in charge email sent successfully"]];
                    $redirect_link = "admin/dashboard";
                }

                $data['errors'] = $club->errors;
            }

            /* fetch results */
            $data["table_data"] = $club->find(["is_deleted" => 0]);

            $db->commit();
        } catch (\Throwable $th) {
            $_SESSION['alerts'] = [["status" => "error", "message" => "Failed to process the action, please try again later."]];
            $db->rollback();
        }

        if ($_SERVER['REQUEST_METHOD'] == "POST" &&  count($data['errors']) == 0) return redirect($redirect_link);

        $this->view($path, $data);
    }

    public function events($path, $data)
    {
        $event = new Event();
        $storage = new Storage();

        $data['total_count'] = 0;
        $data['limit'] = 10;
        $data['page'] = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;


        /* fetch data */
        $data['events_data'] = $event->find(
            [],
            [
                "club_events.id as id",
                "club_events.name as name",
                "club_events.venue as venue",
                "club_events.image as image",
                "club_events.start_datetime as start_datetime",
                "club_events.end_datetime as end_datetime",
                "club_events.state as state",
                "club.id as club_id",
                "club.name as club_name"
            ],
            [
                ["table" => "clubs", "as" => "club", "on" => "club_events.club_id = club.id"]
            ]
        );


        $this->view($path, $data);
    }

    public function requests($path, $data)
    {
        $db = new Database();
        $storage = new Storage();
        $club_request = new ClubRequest($db);
        $club_member = new ClubMember($db);
        $notification = new UserNotifications($db);
        $notification_state = new UserNotificationsState($db);

        $path = $_GET['url'];

        $data['page'] = 1;
        $data['limit'] = 15;

        if (!empty($_GET['page']) && is_numeric($_GET['page']))
            $data['page'] = $_GET['page'];

        $db->transaction();

        try {

            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                $form_data = $_POST;

                if ($form_data['submit'] == 'request-state') {
                    if (!isset($form_data['id'])) {
                        $_SESSION['alerts'] = [["status" => "error", "message" => "Failed to update the request, request ID is not found"]];
                    } else {
                        if ($club_request->validateUpdateRequestState($form_data)) {
                            $club_request->update(["id" => $form_data['id']], [
                                "state" => $form_data['state'],
                                "remarks" => $form_data['remarks'],
                            ]);

                            $request_data = $club_request->one(['id' => $form_data['id']]);

                            /* set notification */
                            $roles = ['PRESIDENT', 'CLUB_IN_CHARGE'];
                            $club_administrators_ids = $club_member->query("select user_id from club_members where club_id = ? && role in (" . trim(str_repeat('?,', count($roles)), ',') . ")", array_merge([$request_data->club_id], $roles), 'array');
                            $admin_users = array_column($club_administrators_ids, 'user_id');

                            if (!empty($admin_users)) {
                                $notification_result = $notification->create([
                                    "title" => 'Club Request State Update',
                                    "description" => '"' . $request_data->subject . '" request with ID "' . $form_data['id'] . '" state has been updated.',
                                ]);

                                foreach ($admin_users as $user_id) {
                                    $notification_state->create([
                                        "user_id" => $user_id,
                                        "notification_id" => $notification_result->id,
                                    ]);
                                }
                            }

                            $_SESSION['alerts'] = [["status" => "success", "message" => "Request state been updated successfully"]];
                        }
                    }
                }

                $data['errors'] = $club_request->errors;
            }

            /* pagination */
            $total_count = $club_request->find([], ["count(*) as count"], [["table" => "club_events", "as" => "event", "on" => "club_requests.club_event_id = event.id"]], ["limit" => $data['limit'], "search" =>  ["club_requests.id", "event.name"]], isset($_GET['search']) ? $_GET['search'] : '');
            if (!empty($total_count[0]->count)) $data['total_count'] = $total_count[0]->count;

            /* fetch club requests */
            $data['table_data'] = $club_request->find(
                [],
                [
                    "club_requests.id",
                    "club_requests.state",
                    "club_requests.subject",
                    "club_requests.description",
                    "club_requests.remarks",
                    "club_requests.created_datetime",
                    "event.name as event_name",
                    "event.start_datetime as event_date",
                ],
                [
                    ["table" => "club_events", "as" => "event", "on" => "club_requests.club_event_id = event.id"]
                ],
                [
                    "limit" => $data['limit'],
                    "offset" => ($data['page'] - 1) * $data['limit'],
                    "search" =>  ["club_requests.id", "event.name"]
                ],
                isset($_GET['search']) ? $_GET['search'] : ''
            );

            $db->commit();
        } catch (\Throwable $th) {
            show($th);
            $db->rollback();
        }

        if ($_SERVER['REQUEST_METHOD'] == "POST" &&  count($data['errors']) == 0) return redirect();

        $this->view($path, $data);
    }


    public function users($path, $data)
    {
        $user = new User();

        $data['total_count'] = 0;
        $data['limit'] = 10;
        $data['page'] = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

        /* pagination */
        $total_count = $user->find([
            "is_deleted" => 0
        ], ["count(*) as count"], [], [], isset($_GET['search']) ? $_GET['search'] : '');
        if (!empty($total_count[0]->count)) $data['total_count'] = $total_count[0]->count;

        /* fetch data */
        $data['users_data'] = $user->find(
            ["users.is_deleted" => 0],
            [
                "users.id",
                "users.id as id",
                "users.first_name",
                "users.last_name",
                "users.email",
                "users.is_verified",
                "club_member.state as club_state",
                "club_member.role as club_role",
                "club.id as club_id",
                "club.name as club_name",
                "club.image as club_image",
                "( select count(*) from club_members where club_members.club_id = club.id and club_members.user_id = users.id ) as total_clubs"
            ],
            [
                ["table" => "club_members", "as" => "club_member", "on" => "users.id = club_member.user_id"],
                ["table" => "clubs", "as" => "club", "on" => "club.id = club_member.club_id"]
            ],
            [
                "type" => "group",
                "limit" => $data['limit'],
                "offset" => ($data['page'] - 1) * $data['limit'],
            ],
            isset($_GET['search']) ? $_GET['search'] : ''
        );

        $this->view($path, $data);
    }
}
