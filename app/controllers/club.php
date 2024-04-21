<?php

use function _\upperCase;

class Club extends Controller
{
    public function index()
    {
        $club = new Clubs();
        $post = new ClubPost();
        $club_member = new ClubMember();
        $event = new Event();
        $club_gallery = new ClubGallery();
        $moment = new \Moment\Moment();
        $data['club_role'] = 'NONE';

        $data = [
            "tab" => "club-posts",
            "club_id" => ""
        ];
        $params = $_GET;

        if (!empty($params["id"])) {
            $data["club_id"] = $params["id"];
        } else {
            return redirect('not-found');
        }

        if (Auth::logged()) {
            $auth_user_id = Auth::getId();
            $user = $club_member->one(["club_id" => $data['club_id'], "user_id" => $auth_user_id], ['role']);

            if (!empty($user)) $data['club_role'] = $user->role;
        }

        $tabs = ['club-posts', 'events', 'gallery'];
        $data["tab"] = getActiveTab($tabs, $_GET);

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            /* logout */
            if ($_POST['submit'] == 'upload-image') {
                if (!empty($_FILES['image']['name'])) {
                    $file_upload = uploadFile('image');

                    $club_gallery->create([
                        "club_id" => $data['club_id'],
                        "image" => $file_upload['url']
                    ]);
                } else {
                    $_SESSION['alerts'] = [["status" => "error", "message" => "Failed to upload the image, please try again later"]];
                }

                return redirect();
            } else if ($_POST['submit'] == 'delete-image') {
                $club_gallery->delete([
                    "id" => $_POST['id']
                ]);

                return redirect();
            }
        }

        $today_events = $event->find(
            [
                "club_id" => $data['club_id'],
                "start_datetime" => [
                    "data" => $moment->format('Y-m-d') . "%",
                    "operator" => "like"
                ],
                "club_events.state" => "ACTIVE"
            ],
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

        $club_data = $club->one(["id" => $data["club_id"]], ["clubs.id", "clubs.name", "clubs.description", "clubs.image"]);
        $left_bar = [
            "club" =>  [
                "id" => $club_data->id,
                "name" => $club_data->name,
                "description" => $club_data->description,
                "image" => $club_data->image,
            ],
            "calendar_data" => [
                "current_path" => "/"
            ]
        ];

        $club_member_options = [
            [
                "club_members.id",
                "club_members.user_id",
                "club_members.role",
                "user.first_name",
                "user.last_name",
                "user.image",
            ], [
                ["table" => "users", "as" => "user", "on" => "club_members.user_id = user.id"]
            ]
        ];

        $president = $club_member->one(["club_members.club_id" => $data['club_id'], "club_members.role" => "PRESIDENT"], ...$club_member_options);
        $secretary = $club_member->one(["club_members.club_id" => $data['club_id'], "club_members.role" => "SECRETARY"], ...$club_member_options);
        $treasurer = $club_member->one(["club_members.club_id" => $data['club_id'], "club_members.role" => "TREASURER"], ...$club_member_options);
        $right_bar = [
            "clubs" => [],
            "events" => $today_events,
            "president" => $president,
            "secretary" => $secretary,
            "treasurer" => $treasurer,
        ];

        $data['left_bar'] = $left_bar;
        $data['right_bar'] = $right_bar;

        /* fetch club posts */
        if ($data['tab'] === 'club-posts') {
            $data['posts'] = $post->find(
                ["club_posts.club_id" => $data["club_id"], "club_posts.is_deleted" => 0],
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
        } else if ($data['tab'] === 'events') {
            $data['events'] = $event->find(
                [
                    "club_events.club_id" => $data['club_id'],
                    "club_events.state" => "ACTIVE"
                ],
                [
                    "club_events.id as id",
                    "club_events.name as name",
                    "club_events.venue as venue",
                    "club_events.image as image",
                    "club_events.description as description",
                    "club_events.start_datetime as start_datetime",
                    "club_events.end_datetime as end_datetime",
                    "club_events.state as state",
                    "club.id as club_id",
                    "club.name as club_name",
                    "club.image as club_image",
                ],
                [
                    ["table" => "clubs", "as" => "club", "on" => "club_events.club_id = club.id"]
                ]
            );
        } else if ($data['tab'] === 'gallery') {
            $data['gallery'] = $club_gallery->find(["club_id" => $data['club_id']]);
        }


        $this->view("club", $data);
    }

    public function dashboard()
    {
        $storage = new Storage();
        $path = $_GET["url"];
        $func = "view";

        $club = new Clubs();

        $club_id = $storage->get('club_id');
        $club_role = $storage->get('club_role');
        $data['club_role'] = $club_role;
        if (empty($club_id)) {
            return redirect('not-found');
        }

        $menu = [
            ["id" => "events", "name" => "Events", "icon" => "emoji_events", "path" => ["/club/dashboard", "/club/dashboard/events/add",  "/club/dashboard/events/edit"], "active" => "false"],
            ["id" => "posts", "name" => "Posts", "icon" => "history_edu", "path" => ["/club/dashboard/posts", "/club/dashboard/posts/add", "/club/dashboard/posts/edit"], "active" => "false"],
            ["id" => "community", "name" => "Community Chat", "icon" => "mark_unread_chat_alt", "path" => ["/club/dashboard/community", "/club/dashboard/community/scroll"], "active" => "false"],
        ];

        /* filter menu */
        if (in_array($club_role, ['MEMBER', 'SECRETARY', 'TREASURER'])) {
            array_push($menu, ["id" => "election", "name" => "Election", "icon" => "how_to_vote", "path" => ["/club/dashboard/election", "/club/dashboard/election/vote", "/club/dashboard/election/result", "/club/dashboard/election/details"], "active" => "false"]);
        }
        if (in_array($club_role, ['CLUB_IN_CHARGE', 'PRESIDENT'])) {
            array_push($menu, ["id" => "election", "name" => "Election", "icon" => "how_to_vote", "path" => ["/club/dashboard/election", "/club/dashboard/election/add", "/club/dashboard/election/edit", "/club/dashboard/election/vote", "/club/dashboard/election/result", "/club/dashboard/election/details"], "active" => "false"], ["id" => "requests", "name" => "Requests", "icon" => "crisis_alert", "path" => ["/club/dashboard/requests", "/club/dashboard/requests/add", "/club/dashboard/requests/edit"], "active" => "false"]);
        }
        if (in_array($club_role, ['CLUB_IN_CHARGE', 'PRESIDENT', 'SECRETARY', 'TREASURER'])) {
            array_splice($menu, 4, 0, [["id" => "members", "name" => "Members", "icon" => "people", "path" => "/club/dashboard/members", "active" => "false"]]);
            array_splice($menu, 6, 0, [["id" => "logs", "name" => "Logs", "icon" => "article", "path" => "/club/dashboard/logs", "active" => "false"]]);
        }
        if (in_array($club_role, ['CLUB_IN_CHARGE', 'PRESIDENT', 'SECRETARY'])) {
            array_splice($menu, 3, 0, [["id" => "meetings", "name" => "Meetings", "icon" => "diversity_2", "path" => "/club/dashboard/meetings", "active" => "false"]]);
            array_push($menu, ["id" => "reports", "name" => "Reports", "icon" => "description", "path" => ["/club/dashboard/reports", "/club/dashboard/reports/add"], "active" => "false"]);
        }

        /* update the active menu item */
        $func = getActiveMenu($menu, $path);

        $club_data = $club->one(["id" => $club_id], ["clubs.id", "clubs.name", "clubs.description", "clubs.image"]);
        $left_bar = [
            "club" =>  [
                "id" => $club_data->id,
                "name" => $club_data->name,
                "description" => $club_data->description,
                "image" => $club_data->image,
            ],
            "menu" => $menu,
        ];

        $menu_side_bar = $left_bar;

        $data = [
            "left_bar" => $left_bar,
            "club_role" => $club_role,
            "menu_side_bar" => $menu_side_bar
        ];

        $this->$func($path, $data);
    }

    private function events($path, $data)
    {
        $db = new Database();
        $club_member = new ClubMember();
        $event = new Event($db);
        $event_group = new EventGroup($db);
        $event_group_member = new EventGroupMember($db);
        $notification = new UserNotifications($db);
        $notification_state = new UserNotificationsState($db);

        $storage = new Storage();
        $club_id = $storage->get('club_id');
        $club_role = $storage->get('club_role');

        $data['total_count'] = 0;
        $data['limit'] = 10;
        $data['page'] = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

        $redirect_link = null;

        if (empty($club_id))  $_SESSION['alerts'] = [["status" => "error", "message" => "Club details are not found"]];

        try {
            $db->transaction();

            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                $form_data = $_POST;
                $group_errors = [];

                if ($form_data['submit'] == 'create_event') {
                    $form_data['club_id'] = $club_id;

                    if ($event->validateCreateEvent($form_data)) {
                        try {
                            $event_result = $event->create([
                                "name" => $form_data['name'],
                                "venue" => $form_data['venue'],
                                "club_id" => $form_data['club_id'],
                                "start_datetime" => $form_data['start_datetime'],
                                "end_datetime" => $form_data['end_datetime'],
                                "created_datetime" => $form_data['created_datetime'],
                                "description" => $form_data['description']
                            ]);
                        } catch (\Throwable $th) {
                            throw new Error("Failed to create an event");
                        }

                        $members = array();
                        foreach ($form_data['groups'] as $key => $group) {
                            $permissions = $group['permissions'];

                            if ($event_group->validateCreateEventGroup($group)) {
                                try {
                                    $event_group_result = $event_group->create([
                                        "name" => $group['name'],
                                        "club_id" => $form_data['club_id'],
                                        "club_event_id" => $event_result->id,
                                        "budget_permission" => empty($permissions['budget_permission']) ? 0 : 1,
                                        "details_permission" => empty($permissions['details_permission']) ? 0 : 1,
                                        "registration_permission" => empty($permissions['registration_permission']) ? 0 :  1,
                                        "sponsor_permission" => empty($permissions['sponsor_permission']) ? 0 : 1,
                                    ]);
                                } catch (\Throwable $th) {
                                    throw new Error("Failed to create an event " . $group['name'] . " group");
                                }

                                foreach ($group['members'] as $member) {
                                    try {
                                        $event_group_member->create([
                                            "club_id" => $form_data['club_id'],
                                            "club_event_id" => $event_result->id,
                                            "club_event_group_id" => $event_group_result->id,
                                            "user_id" => $member['user_id'],
                                            "club_member_id" => $member['id'],
                                        ]);

                                        array_push($members, $member['user_id']);
                                    } catch (\Throwable $th) {
                                        throw new Error("Failed to add member to event " . $group['name'] . " group");
                                    }
                                }
                            }

                            /* create notifications */
                            $notification_result = $notification->create([
                                "title" => 'New Event',
                                "description" => '"' . $form_data['name'] . '" event has been created',
                                // "link" => ROOT . '/events/event?id=' . $event_result->id
                            ]);

                            /* get club administrators */
                            $roles = ['PRESIDENT', 'SECRETARY', 'TREASURER', 'CLUB_IN_CHARGE'];
                            $club_administrators_ids = $club_member->query("select user_id from club_members where club_id = ? && role in (" . trim(str_repeat('?,', count($roles)), ',') . ")", array_merge([$club_id], $roles), 'array');
                            $club_administrators_ids = array_column($club_administrators_ids, 'user_id');

                            $user_ids = array_unique(array_merge($members, $club_administrators_ids));
                            foreach ($user_ids as $user_id) {
                                $notification_state->create([
                                    "user_id" => $user_id,
                                    "notification_id" => $notification_result->id,
                                ]);
                            }

                            if (count($event_group->errors) > 0) {
                                $group_errors[$key] = $event_group->errors;
                            }
                        }

                        $_SESSION['alerts'] = [["status" => "success", "message" => "Created an event successfully"]];
                        $redirect_link = 'club/dashboard';
                    }
                } else if ($_POST['submit'] == 'event-state') {
                    $event->update(["id" => $form_data['id']], [
                        "state" => $form_data['state']
                    ]);

                    $_SESSION['alerts'] = [["status" => "success", "message" => "Event status updated successfully"]];
                    $redirect_link = 'club/dashboard';
                } else if ($_POST['submit'] == 'event-redirect') {
                    $storage = new Storage();
                    $storage->set('club_event_id', $_POST['club_event_id']);

                    return redirect('club/dashboard/events/edit');
                } else if ($_POST['submit'] == 'event-dashboard-redirect') {
                    $storage = new Storage();
                    $storage->set('club_event_id', $_POST['club_event_id']);

                    return redirect('events/dashboard');
                } else if ($_POST['submit'] == 'delete-event') {
                    $event->update(["id" => $form_data['id']], [
                        "is_deleted" => 1
                    ]);

                    $_SESSION['alerts'] = [["status" => "success", "message" => "Event deleted successfully"]];
                }

                $data['errors'] = $event->errors;
                if (count($group_errors) > 0) {
                    $data['errors']['groups'] = $group_errors;
                }
            }

            $db->commit();

            if ($_SERVER['REQUEST_METHOD'] == "POST" && count($data['errors']) == 0) return redirect($redirect_link);
        } catch (\Throwable $th) {
            $db->rollback();
            $_SESSION['alerts'] = [["status" => "error", "message" => $th->getMessage() || "Failed to process the action, please try again later."]];
        }

        /* fetch club members */
        if ($path == 'club/dashboard/events/add' || $path == 'club/dashboard/events/edit') {
            $data['club_members_data'] = $club_member->find(
                ["club_id" => $club_id, "state" => "ACCEPTED"],
                [
                    "club_members.id as id",
                    "user_id",
                    "club_id",
                    "user.first_name",
                    "user.last_name",
                ],
                [
                    ["table" => "users", "as" => "user", "on" => "club_members.user_id = user.id"]
                ]
            );
        }
        /* fetch event details */
        if ($path == 'club/dashboard/events/edit') {
            $storage = new Storage();
            $club_event_id = $storage->get('club_event_id');
            $event_data = $event->one(["id" => $club_event_id, "club_id" => $club_id]);

            $_POST['name'] = $event_data->name;
            $_POST['image'] = $event_data->image;
            $_POST['venue'] = $event_data->venue;
            $_POST['open_registrations'] = $event_data->open_registrations;
            $_POST['is_public'] = $event_data->is_public;
            $_POST['description'] = $event_data->description;
            $_POST['start_datetime'] = $event_data->start_datetime;
            $_POST['end_datetime'] = $event_data->end_datetime;
            $_POST['created_datetime'] = $event_data->created_datetime;

            /* set event budget limits */
            // TODO: set the event budgets
            $event_budget_data = [];
            foreach ($event_budget_data as $budget_id => $budget) {
                $_POST['budgets'][$budget_id] = [
                    "id" => $budget->id,
                    "name" => $budget->name,
                    "amount" => $budget->amount,
                    "description" => $budget->description,
                ];
            }

            /* set event groups */
            $event_group_data = $event_group->find(
                ["club_event_groups.club_event_id" => $club_event_id],
                [
                    "club_event_groups.id as group_id",
                    "club_event_groups.name as group_name",
                    "club_event_groups.club_id as club_id",
                    "club_event_groups.club_event_id as club_event_id",
                    "club_event_groups.budget_permission as budget_permission",
                    "club_event_groups.details_permission as details_permission",
                    "club_event_groups.sponsor_permission as sponsor_permission",
                    "club_event_groups.registration_permission as registration_permission",
                    "member.club_member_id as member_id",
                    "member.user_id as user_id",
                    "user.first_name as first_name",
                    "user.last_name as last_name"
                ],
                [
                    ["table" => "club_event_group_members", "as" => "member", "on" => "member.club_event_group_id = club_event_groups.id"],
                    ["table" => "users", "as" => "user", "on" => "user.id = member.user_id"],
                ],
                [
                    "type" => "group"
                ]
            );

            foreach ($event_group_data as $group_id => $group_data) {
                $_POST['groups'][$group_id] = [
                    "id" => $group_id,
                    "name" => $group_data[0]['group_name'],
                    "permissions" => [
                        "budget_permission" => $group_data[0]['budget_permission'],
                        "details_permission" => $group_data[0]['details_permission'],
                        "registration_permission" => $group_data[0]['registration_permission'],
                        "sponsor_permission" => $group_data[0]['sponsor_permission'],
                    ],
                    "members" => []
                ];

                foreach ($group_data as $group_member) {
                    array_push($_POST['groups'][$group_id]['members'], [
                        "user_id" => $group_member['user_id'],
                        "id" => $group_member['member_id'],
                        "name" => $group_member['first_name'] . " " . $group_member['last_name'],
                    ]);
                }
            }
        }

        /* pagination */
        $user_id = Auth::getId();
        $where = [
            "club_events.club_id" => $club_id,
            "club_events.is_deleted" => 0,
        ];
        $includes = [];

        if ($club_role == 'MEMBER') {
            $where['member.user_id'] = $user_id;
            $includes = [
                ["table" => "club_event_group_members", "as" => "member", "on" => "member.club_event_id = club_events.id"],
            ];
        }

        $total_count = $event->find($where, ["count(*) as count"], $includes, isset($_GET['search']) ? $_GET['search'] : '');
        if (!empty($total_count[0]->count)) $data['total_count'] = $total_count[0]->count;

        /* fetch events */
        $data['events_data'] = $event->find(
            $where,
            [
                "club_events.id",
                "club_events.club_id",
                "club_events.name",
                "club_events.description",
                "club_events.venue",
                "club_events.start_datetime",
                "club_events.end_datetime",
                "club_events.is_public",
                "club_events.image",
                "club_events.state",
                "club_events.open_registrations",
                "club_events.created_datetime",
                "club_events.is_budget_submitted",
                "club_events.president_budgets_verified",
                "club_events.president_budget_remarks",
                "club_events.incharge_budgets_verified",
                "club_events.incharge_budget_remarks",
            ],
            $includes,
            [
                "limit" => $data['limit'],
                "offset" => ($data['page'] - 1) * $data['limit'],
            ],
            isset($_GET['search']) ? $_GET['search'] : ''
        );

        $this->view($path, $data);
    }

    private function members($path, $data)
    {
        $tabs = ['accepted', 'rejected', 'requested'];
        $data["tab"] = getActiveTab($tabs, $_GET);

        $this->view($path, $data);
    }

    private function meetings($path, $data)
    {
        $db = new Database();
        $meeting = new ClubMeeting($db);
        $storage = new Storage();
        $club_id = $storage->get('club_id');

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $form_data = $_POST;

            if ($_POST['submit'] == 'create-event-agenda') {
                if ($meeting->validateAddMeeting($form_data)) {
                    try {
                        $meeting->create([
                            "club_id" => $club_id,
                            "name" => $form_data['name'],
                            "date" => $form_data['date'],
                            "start_time" => $form_data['start_time'],
                            "end_time" => $form_data['end_time'],
                        ]);

                        $_SESSION['alerts'] = [["status" => "success", "message" => "Meeting details added successfully"]];
                    } catch (\Throwable $th) {
                        $_SESSION['alerts'] = [["status" => "error", "message" => "Failed to add Meeting details"]];
                    }

                    return redirect();
                } else {
                    $data['popups']["add-mee"] = true;
                }
            }
        }
        $this->view($path, $data);
    }

    private function community($path, $data)
    {
        $community_chat = new ClubCommunityChat();
        $storage = new Storage();
        $auth_user = Auth::user();
        $page = 1;
        $limit = 15;

        if (!empty($_GET['page']) && is_numeric($_GET['page']))
            $page = $_GET['page'];

        $club_id = $storage->get('club_id');
        $club_member_id = $storage->get('club_member_id');

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $form_data = $_POST;

            $form_data['sender_user_id'] = $auth_user['id'];
            $form_data['sender_club_member_id'] = $club_member_id;
            $form_data['club_id'] = $club_id;

            if ($community_chat->validateCreateMessage($form_data)) {
                try {
                    $community_chat->create($form_data);
                    $_SESSION['alerts'] = [["status" => "success", "message" => "Message sent successfully"]];
                } catch (\Throwable $th) {
                    $_SESSION['alerts'] = [["status" => "success", "message" => "Message sent failed"]];
                }
            }

            $data['errors'] = $community_chat->errors;
        }

        /* get messages related to club */
        $data['messages'] = $community_chat->find(
            ["club_community_chat.club_id" => $club_id],
            [
                "club_community_chat.id",
                "club_community_chat.message",
                "club_community_chat.created_datetime",
                "member.role",
                "concat(user.first_name,' ', user.last_name) as name",
            ],
            [
                ["table" => "users", "as" => "user", "on" => "club_community_chat.sender_user_id = user.id"],
                ["table" => "club_members", "as" => "member", "on" => "club_community_chat.sender_club_member_id = member.id"],
            ],
            [
                "limit" => $limit,
                "offset" => ($page - 1) * $limit
            ]
        );

        if ($_SERVER['REQUEST_METHOD'] == "POST" && count($data['errors']) == 0) return redirect();

        $this->view($path, $data);
    }

    private function requests($path, $data)
    {
        $db = new Database();
        $storage = new Storage();
        $user = new User($db);
        $clubs = new Clubs($db);
        $events = new Event($db);
        $club_request = new ClubRequest($db);
        $notification = new UserNotifications($db);
        $notification_state = new UserNotificationsState($db);

        $club_id = $storage->get('club_id');
        $path = $_GET['url'];

        $redirect_link = null;
        $data['page'] = 1;
        $data['limit'] = 15;

        if (!empty($_GET['page']) && is_numeric($_GET['page']))
            $data['page'] = $_GET['page'];

        $db->transaction();

        try {
            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                $form_data = $_POST;
                $form_data['club_id'] = $club_id;

                if ($form_data['submit'] == 'create-request') {
                    if ($club_request->validateCreateRequest($form_data)) {
                        $club_request->create([
                            "club_id" => $club_id,
                            "subject" => $form_data['subject'],
                            "description" => $form_data['description'],
                            "club_event_id" => $form_data['club_event_id'],
                        ]);

                        /* set notification */
                        $super_admin = $user->one(["role" => "SUPER_ADMIN"]);
                        $club = $clubs->one(["id" => $club_id]);
                        if (!empty($super_admin)) {
                            $notification_result = $notification->create([
                                "title" => 'New Club Request',
                                "description" => '"' . $club->name . '" has sent a club request.',
                            ]);

                            $notification_state->create([
                                "user_id" => $super_admin->id,
                                "notification_id" => $notification_result->id,
                            ]);
                        }

                        $redirect_link = 'club/dashboard/requests';
                        $_SESSION['alerts'] = [["status" => "success", "message" => "Request has been sent successfully"]];
                    }
                } else if ($form_data['submit'] == 'update-request') {
                    if (!isset($_GET['id'])) {
                        $_SESSION['alerts'] = [["status" => "error", "message" => "Failed to update the request, request ID is not found"]];
                    } else if (empty($club_request->one(['id' => $_GET['id'], 'club_id' => $club_id]))) {
                        $_SESSION['alerts'] = [["status" => "error", "message" => "Failed to update the request, request details not found"]];
                    } else {
                        $form_data['id'] = $_GET['id'];

                        if ($club_request->validateUpdateRequest($form_data)) {
                            $club_request->update(["id" => $form_data['id']], [
                                "subject" => $form_data['subject'],
                                "description" => $form_data['description'],
                                "club_event_id" => $form_data['club_event_id'],
                            ]);

                            /* set notification */
                            $super_admin = $user->one(["role" => "SUPER_ADMIN"]);
                            $club = $clubs->one(["id" => $club_id], ["clubs.name"]);
                            if (!empty($super_admin)) {
                                $notification_result = $notification->create([
                                    "title" => 'Club Request Update',
                                    "description" => '"' . $club->name . '" request with ID "' . $form_data['id'] . '" has been updated.',
                                ]);

                                $notification_state->create([
                                    "user_id" => $super_admin->id,
                                    "notification_id" => $notification_result->id,
                                ]);
                            }
                        }

                        $_SESSION['alerts'] = [["status" => "success", "message" => "Request has been updated successfully"]];
                    }
                } else if ($form_data['submit'] == 'delete-request') {
                    $club_request->delete(["id" => $form_data['id']]);

                    /* set notification */
                    $super_admin = $user->one(["role" => "SUPER_ADMIN"]);
                    $club = $clubs->one(["id" => $club_id]);
                    if (!empty($super_admin)) {
                        $notification_result = $notification->create([
                            "title" => 'Club Request Removed',
                            "description" => '"' . $club->name . '" request with ID "' . $form_data['id'] . '" has been removed.',
                        ]);

                        $notification_state->create([
                            "user_id" => $super_admin->id,
                            "notification_id" => $notification_result->id,
                        ]);
                    }

                    $_SESSION['alerts'] = [["status" => "success", "message" => "Request has been removed successfully"]];
                }

                $data['errors'] = $club_request->errors;
            }

            /* pagination */
            $total_count = $club_request->find([
                "club_requests.club_id" => $club_id
            ], ["count(*) as count"], [["table" => "club_events", "as" => "event", "on" => "club_requests.club_event_id = event.id"]], ["search" =>  ["event.name"]], isset($_GET['search']) ? $_GET['search'] : '');
            if (!empty($total_count[0]->count)) $data['total_count'] = $total_count[0]->count;

            /* fetch club requests */
            $data['table_data'] = $club_request->find(
                ["club_requests.club_id" => $club_id],
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
                    "search" =>  ["event.name"]
                ],
                isset($_GET['search']) ? $_GET['search'] : ''
            );

            if ($path == 'club/dashboard/requests/add' || $path == 'club/dashboard/requests/edit') {
                $data['event_data'] = $events->find(
                    ["club_id" => $club_id],
                    [
                        "club_events.id",
                        "club_events.name",
                    ],
                    [],
                    [
                        "all" => true
                    ]
                );
            }


            if ($path == 'club/dashboard/requests/edit') {
                if (!isset($_GET['id'])) return redirect('not-found');

                $request_data = $club_request->one(['id' => $_GET['id'], 'club_id' => $club_id]);

                $_POST['subject'] = $request_data->subject;
                $_POST['description'] = $request_data->description;
                $_POST['club_event_id'] = $request_data->club_event_id;
            }

            $db->commit();
        } catch (\Throwable $th) {
            $db->rollback();
            show($th);
            $_SESSION['alerts'] = [["status" => "error", "message" => "Failed to process the action. Please try again later"]];
        }

        if ($_SERVER['REQUEST_METHOD'] == "POST" && count($data['errors']) == 0) return redirect($redirect_link);

        $this->view($path, $data);
    }

    private function reports($path, $data)
    {
        $this->view($path, $data);
    }

    private function posts($path, $data)
    {

        $db = new Database();
        $post = new ClubPost($db);
        $post_log = new ClubPostLogs($db);

        $storage = new Storage();
        $club_id = $storage->get('club_id');
        $club_member_id = $storage->get('club_member_id');
        $user_id = Auth::getId();

        $image_uploaded = true;
        $redirect = 'club/dashboard/posts';

        if (empty($club_id)) $_SESSION['alerts'] = [["status" => "error", "message" => "Club details are not found"]];

        try {
            $db->transaction();

            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                $form_data = $_POST;
                $form_data['club_id'] = $club_id;
                $form_data['user_id'] = $user_id;

                $post_log_data = [
                    "club_id" => $club_id,
                    "user_id" => $user_id,
                    "club_member_id" => $club_member_id,
                    "club_post_id" => "",
                    "description" => ""
                ];

                if ($form_data['submit'] == 'post-redirect') {
                    $storage = new Storage();
                    $storage->set('club_post_id',  $form_data['club_post_id']);

                    return redirect('club/dashboard/posts/edit');
                } else if ($_POST['submit'] == "create-post") {
                    /* save uploaded image */
                    if (!empty($_FILES['image']['name'])) {
                        $file_upload = uploadFile('image');

                        if (empty($file_upload)) {
                            $image_uploaded = false;
                            $data["errors"]["image"] = "Failed to upload the image, please try again later";
                        } else {
                            $form_data['image'] = $_POST['image'] = $file_upload['url'];
                        }
                    } else if (!empty($form_data['pre_uploaded_image'])) {
                        $form_data['image'] = $_POST['image'] = $form_data['pre_uploaded_image'];
                    }

                    if ($image_uploaded && $post->validateCreatePost($form_data)) {
                        try {
                            $post_log_data['description'] = "Uploaded a new post to club profile";

                            /* create post record */
                            $result = $post->create([
                                "user_id" => $user_id,
                                "club_id" => $club_id,
                                "post_name" => $form_data['post_name'],
                                "description" => $form_data['description'],
                                "created_datetime" => $form_data['created_datetime'],
                                "image" => $form_data['image']
                            ]);

                            /* create log for action */
                            if (!empty($result)) {
                                $post_log_data["club_post_id"] = $result->id;
                                $post_log->create($post_log_data);
                            }

                            $_SESSION['alerts'] = [["status" => "success", "message" => "Post details added successfully"]];

                            $redirect = 'club/dashboard/posts';
                        } catch (\Throwable $th) {
                            throw new Error("Failed to upload club post");
                        }
                    }
                } else if ($_POST['submit'] == "edit-post") {
                    try {
                        /* save uploaded image */
                        if (!empty($_FILES['image']['name'])) {
                            $file_upload = uploadFile('image');

                            if (empty($file_upload)) {
                                $image_uploaded = false;
                                $data["errors"]["image"] = "Failed to upload the image, please try again later";
                            } else {
                                $form_data['image'] = $_POST['image'] = $file_upload['url'];
                            }
                        } else if (!empty($form_data['pre_uploaded_image'])) {
                            $form_data['image'] = $_POST['image'] = $form_data['pre_uploaded_image'];
                        }

                        $post_log_data['description'] = "Updated club post";

                        /* update post record */
                        $result = $post->update([
                            "id" => $form_data["id"]
                        ], [
                            "post_name" => $form_data['post_name'],
                            "description" => $form_data['description'],
                            "image" => $form_data['image']
                        ]);

                        /* create log for action */
                        $post_log_data["club_post_id"] = $form_data["id"];
                        $post_log->create($post_log_data);

                        $_SESSION['alerts'] = [["status" => "success", "message" => "Post details updated successfully"]];

                        $redirect = 'club/dashboard/posts';
                    } catch (\Throwable $th) {
                        throw new Error("Failed to update club post");
                    }
                } else if ($_POST['submit'] == "delete-club-post") {
                    try {
                        $post_log_data['description'] = "Deleted club post";

                        /* delete post record */
                        $post->update(["id" => $form_data['id']], ["is_deleted" => 1]);

                        /* create log for action */
                        $post_log_data["club_post_id"] = $form_data["id"];
                        $post_log->create($post_log_data);

                        $redirect = 'club/dashboard/posts';

                        $_SESSION['alerts'] = [["status" => "success", "message" => "Post details deleted successfully"]];
                    } catch (Throwable $th) {
                        throw new Error("Failed to delete club post");
                    }
                }
            }

            /* fetch post details */
            if ($path == 'club/dashboard/posts/edit') {
                $post_id = $storage->get('club_post_id');

                if (empty($post_id)) return redirect('club/dashboard/posts');

                $result = $post->one(
                    ["id" => $post_id],
                );

                $_POST['id'] = $result->id;
                $_POST['post_name'] = $result->post_name;
                $_POST['description'] = $result->description;
                $_POST['image'] = $result->image;
            } else {
                /* fetch club posts */
                $posts_data = $post->find(
                    ["club_id" => $club_id, "club_posts.is_deleted" => 0],
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
                    [],
                    isset($_GET['search']) ? $_GET['search'] : ''
                );
                $data['posts_data'] = $posts_data;
            }

            $data['errors'] = $post->errors;

            $db->commit();

            if ($_SERVER['REQUEST_METHOD'] == "POST" &&  count($data['errors']) == 0) return redirect($redirect);
        } catch (\Throwable $th) {
            $db->rollback();

            $_SESSION['alerts'] = [["status" => "error", "message" => $th->getMessage() || "Failed to process the action, please try again later."]];
            return redirect($redirect);
        }


        $this->view($path, $data);
    }

    private function logs($path, $data)
    {
        $tabs = ['posts', 'budgets'];
        $data["tab"] = getActiveTab($tabs, $_GET);

        $storage = new Storage();
        $budget_log = new BudgetLogs();
        $post_log = new ClubPostLogs();

        $club_id = $storage->get('club_id');

        $data['total_count'] = 0;
        $data['limit'] = 10;
        $data['page'] = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
        $table_data = [];

        if ($data['tab'] == 'posts') {
            /* fetch data */
            $table_data = $post_log->find(
                ["club_post_logs.club_id" => $club_id],
                [
                    "club_post_logs.id",
                    "club_post_logs.club_post_id",
                    "club_post_logs.description as log_description",
                    "club_post_logs.created_at",
                    "club_post_logs.updated_at",
                    "user.email",
                    "user.first_name",
                    "user.last_name",
                    "post.post_name",
                    "post.description as description",
                    "post.image as image",
                    "post.club_id as club_id",
                    "post.created_datetime as created_datetime",
                    "club.name as club_name",
                    "club.image as club_image",
                ],
                [
                    ["table" => "club_posts", "as" => "post", "on" => "club_post_logs.club_post_id = post.id"],
                    ["table" => "users", "as" => "user", "on" => "club_post_logs.user_id = user.id"],
                    ["table" => "clubs", "as" => "club", "on" => "club_post_logs.club_id = club.id"],
                ],
                [
                    "limit" => $data['limit'],
                    "offset" => ($data['page'] - 1) * $data['limit'],
                ],
                isset($_GET['search']) ? $_GET['search'] : ''
            );

            /* pagination */
            $total_count = $post_log->find([
                "club_id" => $club_id,
            ], ["count(*) as count"], [], [], isset($_GET['search']) ? $_GET['search'] : '');
            if (!empty($total_count[0]->count)) $data['total_count'] = $total_count[0]->count;
        } else if ($data['tab'] == 'budgets') {
            /* fetch data */
            $table_data = $budget_log->find(
                ["club_event_budget_logs.club_id" => $club_id],
                [
                    "club_event_budget_logs.id",
                    "club_event_budget_logs.club_event_budget_id",
                    "club_event_budget_logs.description",
                    "club_event_budget_logs.type",
                    "club_event_budget_logs.created_at",
                    "club_event_budget_logs.updated_at",
                    "user.email",
                    "user.first_name",
                    "user.last_name",
                    "event.name as event_name",
                    "budget.name as budget_name",
                ],
                [
                    ["table" => "club_event_budgets", "as" => "budget", "on" => "club_event_budget_logs.club_event_budget_id = budget.id"],
                    ["table" => "club_events", "as" => "event", "on" => "club_event_budget_logs.club_event_id = event.id"],
                    ["table" => "users", "as" => "user", "on" => "club_event_budget_logs.user_id = user.id"],
                ],
                [
                    "limit" => $data['limit'],
                    "offset" => ($data['page'] - 1) * $data['limit'],
                    "search" =>  ["user.email", "user.first_name", "user.last_name", "budget.name"]
                ],
                isset($_GET['search']) ? $_GET['search'] : ''
            );

            /* pagination */
            $total_count = $budget_log->find([
                "club_id" => $club_id,
            ], ["count(*) as count"], [], [], isset($_GET['search']) ? $_GET['search'] : '');
            if (!empty($total_count[0]->count)) $data['total_count'] = $total_count[0]->count;
        }

        $data['table_data'] = $table_data;

        $this->view($path, $data);
    }
    private function election($path, $data)
    {
        $db = new Database();
        $club_member = new ClubMember($db);
        $club_election = new ClubElection($db);
        $club_election_candidates = new ClubElectionCandidates($db);
        $club_election_voters = new ClubElectionVoters($db);
        $club_election_vote = new ClubElectionVotes($db);
        $notification = new UserNotifications($db);
        $notification_state = new UserNotificationsState($db);

        $storage = new Storage();
        $club_id = $storage->get('club_id');
        $redirect_on_success = true;

        $tabs = ['votes', 'elections'];
        $data["tab"] = getActiveTab($tabs, $_GET);

        $data['total_count'] = 0;
        $data['limit'] = 10;
        $data['page'] = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

        $redirect_link = 'club/dashboard/election';

        try {
            $db->transaction();
            $data['errors'] = [];

            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                $form_data = $_POST;

                $form_data['club_id'] = $club_id;

                if ($form_data['submit'] == 'create-election') {
                    if ($club_election->validateCreate($form_data)) {
                        /* create election */
                        $club_election_result = $club_election->create([
                            "club_id" => $form_data['club_id'],
                            "title" => $form_data['title'],
                            "description" => $form_data['description'],
                            "start_datetime" => $form_data['start_datetime'],
                            "end_datetime" => $form_data['end_datetime'],
                        ]);

                        /* add candidates according to role */
                        $roles = ['president', 'secretary', 'treasurer'];
                        $candidate_members = array();
                        foreach ($roles as $role) {
                            if (!empty($form_data[$role . '_candidate']) && is_array($form_data[$role . '_candidate'])) {
                                foreach ($form_data[$role . '_candidate'] as $candidate) {
                                    $club_election_candidates->create([
                                        "club_id" => $form_data['club_id'],
                                        "user_id" => $candidate['user_id'],
                                        "club_member_id" => $candidate['id'],
                                        "election_id" => $club_election_result->id,
                                        "role" => strtoupper($role)
                                    ]);

                                    array_push($candidate_members, $candidate['user_id']);
                                }
                            }
                        }

                        $vote_members = array();
                        if (!empty($form_data['voter']) && is_array($form_data['voter'])) {
                            foreach ($form_data['voter'] as $voter) {
                                $club_election_voters->create([
                                    "club_id" => $form_data['club_id'],
                                    "user_id" => $voter['user_id'],
                                    "club_member_id" => $voter['id'],
                                    "election_id" => $club_election_result->id
                                ]);

                                array_push($vote_members, $voter['user_id']);
                            }
                        }

                        /* club administrators notification */
                        $roles = ['PRESIDENT', 'SECRETARY', 'TREASURER', 'CLUB_IN_CHARGE'];
                        $club_administrators_ids = $club_member->query("select user_id from club_members where club_id = ? && role in (" . trim(str_repeat('?,', count($roles)), ',') . ")", array_merge([$club_id], $roles), 'array');
                        $admin_users = array_column($club_administrators_ids, 'user_id');

                        $admin_notification_result = $notification->create([
                            "title" => 'New Election',
                            "description" => '"' . $form_data['title'] . '" election has been created.',
                        ]);

                        foreach ($admin_users as $user_id) {
                            $notification_state->create([
                                "user_id" => $user_id,
                                "notification_id" => $admin_notification_result->id,
                            ]);
                        }

                        /* candidate election notifications */
                        $candidate_notification_result = $notification->create([
                            "title" => 'Election Candidate',
                            "description" => 'You have been selected as a candidate for the "' . $form_data['title'] . '" election.',
                        ]);

                        $candidate_users = array_unique($candidate_members);
                        foreach ($candidate_users as $user_id) {
                            $notification_state->create([
                                "user_id" => $user_id,
                                "notification_id" => $candidate_notification_result->id,
                            ]);
                        }

                        /* vote election notifications */
                        $vote_notification_result = $notification->create([
                            "title" => 'Election Vote',
                            "description" => 'You have been selected as a voter for the "' . $form_data['title'] . '" election.',
                        ]);

                        $vote_users = array_unique($vote_members);
                        foreach ($vote_users as $user_id) {
                            $notification_state->create([
                                "user_id" => $user_id,
                                "notification_id" => $vote_notification_result->id,
                            ]);
                        }
                    }

                    $data['errors'] = $club_election->errors;

                    $_SESSION['alerts'] = [["status" => "success", "message" => "Election created successfully"]];
                } else if ($form_data['submit'] == 'edit-election') {
                    if ($club_election->validateUpdate($form_data)) {
                        /* delete all candidates and voters related to the election */
                        $club_election_candidates->delete(["election_id" => $form_data['id']]);
                        $club_election_voters->delete(["election_id" => $form_data['id']]);

                        /* create election */
                        $club_election_result = $club_election->update(
                            [
                                "id" => $form_data['id']
                            ],
                            [
                                "club_id" => $form_data['club_id'],
                                "title" => $form_data['title'],
                                "description" => $form_data['description'],
                                "start_datetime" => $form_data['start_datetime'],
                                "end_datetime" => $form_data['end_datetime'],
                            ]
                        );

                        /* add candidates according to role */
                        $roles = ['president', 'secretary', 'treasurer'];
                        $candidate_members = array();
                        foreach ($roles as $role) {
                            if (!empty($form_data[$role . '_candidate']) && is_array($form_data[$role . '_candidate'])) {
                                foreach ($form_data[$role . '_candidate'] as $candidate) {
                                    $club_election_candidates->create([
                                        "club_id" => $form_data['club_id'],
                                        "user_id" => $candidate['user_id'],
                                        "club_member_id" => $candidate['id'],
                                        "election_id" => $form_data['id'],
                                        "role" => strtoupper($role)
                                    ]);

                                    array_push($candidate_members, $candidate['user_id']);
                                }
                            }
                        }

                        /* add voters */
                        $vote_members = array();
                        if (!empty($form_data['voter']) && is_array($form_data['voter'])) {
                            foreach ($form_data['voter'] as $voter) {
                                $club_election_voters->create([
                                    "club_id" => $form_data['club_id'],
                                    "user_id" => $voter['user_id'],
                                    "club_member_id" => $voter['id'],
                                    "election_id" => $form_data['id']
                                ]);

                                array_push($vote_members, $voter['user_id']);
                            }
                        }
                    }

                    $data['errors'] = $club_election->errors;

                    $_SESSION['alerts'] = [["status" => "success", "message" => "Election updated successfully"]];
                } else if ($_POST['submit'] == "delete-election") {
                    $club_election->update(["id" => $form_data['id']], ["is_deleted" => 1]);

                    $_SESSION['alerts'] = [["status" => "success", "message" => "Election deleted successfully"]];
                } else if ($form_data['submit'] == 'election-state') {
                    $club_election->update(["id" => $form_data["id"]], [
                        "state" => $form_data['state']
                    ]);

                    $_SESSION['alerts'] = [["status" => "success", "message" => "Election status updated successfully"]];
                } else if ($form_data['submit'] == 'vote-election') {
                    $tabs = ['president', 'secretary', 'treasurer'];
                    $role = getActiveTab($tabs, $_GET);

                    $user_id = Auth::getId();
                    if (empty($_GET["election"])) return redirect('not-found');

                    $election_voter = $club_election_voters->one(["user_id" => $user_id, "election_id" => $_GET['election']]);
                    if (empty($election_voter)) return redirect('not-found');

                    $form_data['club_election_id'] = $_GET['election'];
                    $form_data['voter_id'] = $election_voter->id;
                    $form_data['role'] = $role;

                    if ($club_election_vote->validateCreate($form_data)) {
                        if ($club_election_vote->one([
                            "role" => strtoupper($role),
                            "club_id" => $form_data['club_id'],
                            "club_election_id" => $form_data['club_election_id'],
                            "voter_id" => $form_data['voter_id'],
                        ])) {
                            $_SESSION['alerts'] = [["status" => "error", "message" => "You have already voted"]];

                            return redirect();
                        } {
                            /* updated election voter state */
                            $club_election_voters->update([
                                "id" => $form_data['voter_id']
                            ], [
                                "did_vote" => 1
                            ]);

                            /* add president vote */
                            $club_election_vote->create([
                                "role" => strtoupper($role),
                                "club_id" => $form_data['club_id'],
                                "club_election_id" => $form_data['club_election_id'],
                                "voter_id" => $form_data['voter_id'],
                                "selected_candidate_id" => $form_data['candidate'],
                                "description" => empty($form_data['description']) ? '' : $form_data['description'],
                            ]);

                            $_SESSION['alerts'] = [["status" => "success", "message" => "Election voted successfully"]];
                        }

                        $data["errors"] = $club_election_vote->errors;

                        $redirect_on_success = false;
                        $redirect_link = null;
                    }
                }
            }

            if ($path == 'club/dashboard/election/add' || $path == 'club/dashboard/election/edit') {
                $data['select_users']['total_count'] = 0;
                $data['select_users']['limit'] = 10;
                $data['select_users']['page'] = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
                $where = null;

                if (isset($_GET['filter_event_percentage'])) {

                    $data['select_users']['percentage'] = $_GET['filter_event_percentage'];

                    $where = [
                        "(
                            (select count(*) from club_event_registrations er where er.user_email = user.email and er.club_id = '" . $club_id . "') / 
                            (select count(*) from club_events ce where ce.club_id = '" . $club_id . "')
                        ) * 100 > " . $data['select_users']['percentage']
                    ];
                }

                /* if the view requires only specific data view */
                if (isset($_GET['data'])) {
                    if ($_GET['data'] == 'users_data') {
                        $path = 'includes/modals/club/election/users/data';
                    }
                }

                /* pagination */
                $total_count = $club_member->find(
                    ["club_id" => $club_id, "state" => "ACCEPTED"],
                    ["count(*) as count"],
                    [["table" => "users", "as" => "user", "on" => "club_members.user_id = user.id"]],
                    [
                        "where" => $where,
                        "search" => ["user.email", "user.first_name", "user.last_name"],
                        "limit" => $data['select_users']['limit'],
                        "offset" => ($data['select_users']['page'] - 1) * $data['select_users']['limit'],
                    ],
                    isset($_GET['search']) ? $_GET['search'] : ''
                );
                if (!empty($total_count[0]->count)) $data['select_users']['total_count'] = $total_count[0]->count;

                /* data */
                $data['select_users']['table_data'] =  $club_member->find(
                    ["club_id" => $club_id, "state" => "ACCEPTED"],
                    [
                        "club_members.id as id",
                        "user_id",
                        "club_id",
                        "joined_datetime",
                        "user.email",
                        "user.first_name",
                        "user.last_name",
                    ],
                    [
                        ["table" => "users", "as" => "user", "on" => "club_members.user_id = user.id"]
                    ],
                    [
                        "where" => $where,
                        "search" => ["user.email", "user.first_name", "user.last_name"],
                        "limit" => $data['select_users']['limit'],
                        "offset" => ($data['select_users']['page'] - 1) * $data['select_users']['limit'],
                    ],
                    isset($_GET['search']) ? $_GET['search'] : ''
                );
            }

            /* fetch election data for the form */
            if ($path == 'club/dashboard/election/edit') {
                if (empty($_GET['id'])) {
                    return redirect('not-found');
                }

                /* if the election is opened or closed do not let them edit */
                $election_data = $club_election->one(
                    ["club_id" => $club_id, "id" => $_GET['id'], "state" => "PENDING"]
                );

                $_POST['id'] = $election_data->id;
                $_POST['title'] = $election_data->title;
                $_POST['description'] = $election_data->description;
                $_POST['start_datetime'] = $election_data->start_datetime;
                $_POST['end_datetime'] = $election_data->end_datetime;

                /* election candidates */
                $roles = ['president', 'secretary', 'treasurer'];
                foreach ($roles as $role) {
                    $_POST[$role . '_candidate'] = $club_election_candidates->find([
                        "election_id" => $_GET['id'],
                        "club_election_candidates.role" => strtoupper($role)
                    ], [
                        "club_election_candidates.club_member_id as id",
                        "club_election_candidates.user_id",
                        "club_election_candidates.club_id",
                        "concat(user.first_name,' ', user.last_name) as name",
                    ], [
                        ["table" => "users", "as" => "user", "on" => "club_election_candidates.user_id = user.id"]
                    ], ["type" => "array"]);
                }


                /* election voters */
                $_POST['voter'] = $club_election_voters->find([
                    "election_id" => $_GET['id']
                ], [
                    "club_election_voters.club_member_id as id",
                    "club_election_voters.user_id",
                    "club_election_voters.club_id",
                    "concat(user.first_name,' ', user.last_name) as name",
                ], [
                    ["table" => "users", "as" => "user", "on" => "club_election_voters.user_id = user.id"]
                ], ["type" => "array"]);
            }

            /* election vote data */
            if ($path == 'club/dashboard/election/vote') {
                $tabs = ['president', 'secretary', 'treasurer'];
                $data["tab"] = getActiveTab($tabs, $_GET);

                $user_id = Auth::getId();
                if (empty($_GET["election"])) return redirect('not-found');

                /* get election details */
                $data['election_id'] = $_GET["election"];
                $data['election'] = $club_election->one(["id" => $data['election_id'], "state" => "OPEN"]);
                if (empty($data['election'])) return redirect('not-found');

                /* get election voter details */
                $election_voter = $club_election_voters->one(["user_id" => $user_id, "election_id" => $_GET['election']]);
                if (empty($election_voter)) return redirect('not-found');

                $data['candidate_members_data'] = $club_election_candidates->find(
                    ["club_id" => $club_id, "election_id" => $_GET["election"], "club_election_candidates.role" => strtoupper($data['tab'])],
                    [
                        "club_election_candidates.id as id",
                        "club_election_candidates.club_member_id as club_member_id",
                        "club_election_candidates.user_id",
                        "club_election_candidates.club_id",
                        "user.first_name",
                        "user.last_name",
                        "user.image",
                    ],
                    [
                        ["table" => "users", "as" => "user", "on" => "club_election_candidates.user_id = user.id"]
                    ]
                );
            }

            if ($path == 'club/dashboard/election/details') {
                $tabs = ['president', 'secretary', 'treasurer'];
                $data["tab"] = getActiveTab($tabs, $_GET);

                $user_id = Auth::getId();
                if (empty($_GET["election_id"])) return redirect('not-found');

                /* get election details */
                $data['election_id'] = $_GET["election_id"];
                $data['election'] = $club_election->one(["id" => $data['election_id']]);
                if (empty($data['election'])) return redirect('not-found');

                $data['candidate_members_data'] = $club_election_candidates->find(
                    ["club_id" => $club_id, "election_id" => $data["election_id"], "club_election_candidates.role" => strtoupper($data['tab'])],
                    [
                        "club_election_candidates.id as id",
                        "club_election_candidates.user_id as user_id",
                        "club_election_candidates.club_member_id as club_member_id",
                        "club_election_candidates.user_id",
                        "club_election_candidates.club_id",
                        "user.first_name",
                        "user.last_name",
                        "user.image",
                    ],
                    [
                        ["table" => "users", "as" => "user", "on" => "club_election_candidates.user_id = user.id"]
                    ]
                );
            }

            /* data fetching */
            if ($path == 'club/dashboard/election' && $data['tab'] == 'votes') {
                $user_id = Auth::getId();

                /* count */
                $total_count = $club_election->find([
                    "club_elections.club_id" => $club_id,
                    "club_elections.is_deleted" => 0,
                    "voter.user_id" => $user_id
                ], ["count(*) as count"], [
                    ["table" => "club_election_voters", "as" => "voter", "on" => "club_elections.id = voter.election_id"]
                ], [], isset($_GET['search']) ? $_GET['search'] : '');
                if (!empty($total_count[0]->count)) $data['total_count'] = $total_count[0]->count;

                /* data */
                $data['election_data'] = $club_election->find([
                    "club_elections.club_id" => $club_id,
                    "club_elections.is_deleted" => 0,
                    "voter.user_id" => $user_id,
                ], [
                    "club_elections.id",
                    "club_elections.title",
                    "club_elections.state",
                    "club_elections.start_datetime",
                    "club_elections.end_datetime",
                    "club_elections.description",
                    "club_elections.club_id",
                    "voter.did_vote"
                ], [
                    ["table" => "club_election_voters", "as" => "voter", "on" => "club_elections.id = voter.election_id"]
                ], [
                    "limit" => $data['limit'],
                    "offset" => ($data['page'] - 1) * $data['limit'],
                ], isset($_GET['search']) ? $_GET['search'] : '');
            } else if ($path == 'club/dashboard/election' && $data['tab'] == 'elections') {
                /* count */
                $total_count = $club_election->find([
                    "club_id" => $club_id,
                    "is_deleted" => 0,
                ], ["count(*) as count"], [], [], isset($_GET['search']) ? $_GET['search'] : '');
                if (!empty($total_count[0]->count)) $data['total_count'] = $total_count[0]->count;

                /* data */
                $data['election_data'] = $club_election->find([
                    "club_id" => $club_id,
                    "is_deleted" => 0,
                ], [], [], [
                    "limit" => $data['limit'],
                    "offset" => ($data['page'] - 1) * $data['limit'],
                ], isset($_GET['search']) ? $_GET['search'] : '');
            }

            if ($path == 'club/dashboard/election/result') {
                if (empty($_GET['club_id']) || empty($_GET['election_id'])) {
                    return redirect('club/dashboard/election');
                }

                $tabs = ['president', 'secretary', 'treasurer'];
                $data["tab"] = getActiveTab($tabs, $_GET);

                $data['club_id'] = $_GET['club_id'];
                $data['election_id'] = $_GET['election_id'];

                $data['election'] = $club_election->one(['id' => $data['election_id']], ["title", "description"]);
                if (empty($data['election'])) {
                    return redirect('club/dashboard/election');
                }

                $data['election_results'] = $club_election_candidates->find([
                    "club_election_candidates.club_id" => $data['club_id'],
                    "club_election_candidates.election_id" =>  $data['election_id'],
                ], [
                    "club_election_candidates.id as id",
                    "user.first_name",
                    "user.last_name",
                    "user.image",
                    "(select count(*) from club_election_votes votes where votes.selected_candidate_id = club_election_candidates.id and votes.role = '" . strtoupper($data['tab']) . "') as votes",
                    "(select count(*) from club_election_votes votes where votes.selected_candidate_id = club_election_candidates.id and votes.role = '" . strtoupper($data['tab']) . "') /
                         (select count(*) from club_election_voters votes where votes.election_id = '" .  $data['election_id'] . "') * 100 as vote_percentage",
                ], [
                    ["table" => "users", "as" => "user", "on" => "club_election_candidates.user_id = user.id"],
                ], [
                    "order_column" => "votes"
                ]);
            }

            $db->commit();

            if ($redirect_on_success && $_SERVER['REQUEST_METHOD'] == "POST" &&  count($data['errors']) == 0) return redirect($redirect_link);
        } catch (\Throwable $th) {
            show($th);
            $db->rollback();
            $_SESSION['alerts'] = [["status" => "error", "message" => $th->getMessage() || "Failed to process the action, please try again later."]];
        }

        $this->view($path, $data);
    }
}
