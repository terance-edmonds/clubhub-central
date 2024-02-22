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
        $moment = new \Moment\Moment();

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

        $tabs = ['club-posts', 'events'];
        $data["tab"] = getActiveTab($tabs, $_GET);

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
            $posts = $post->find(
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

            $data['posts'] = $posts;
        } else if ($data['tab'] === 'events') {
            $events = $event->find(
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

            $data['events'] = $events;
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

        if (empty($club_id)) {
            return redirect('not-found');
        }

        $menu = [
            ["id" => "events", "name" => "Events", "icon" => "emoji_events", "path" => ["/club/dashboard", "/club/dashboard/events/add",  "/club/dashboard/events/edit"], "active" => "false"],
            ["id" => "posts", "name" => "Posts", "icon" => "history_edu", "path" => ["/club/dashboard/posts", "/club/dashboard/posts/add", "/club/dashboard/posts/edit"], "active" => "false"],
            ["id" => "community", "name" => "Community Chat", "icon" => "mark_unread_chat_alt", "path" => "/club/dashboard/community", "active" => "false"],
        ];

        /* filter menu */
        if (in_array($club_role, ['CLUB_IN_CHARGE', 'PRESIDENT', 'TREASURER'])) {
            array_splice($menu, 1, 0, [["id" => "budgets", "name" => "Event Budgets", "icon" => "savings", "path" => ["/club/dashboard/budgets", "/club/dashboard/budgets/edit"], "active" => "false"]]);
        }
        if (in_array($club_role, ['MEMBER', 'SECRETARY', 'TREASURER'])) {
            array_push($menu, ["id" => "election", "name" => "Election", "icon" => "how_to_vote", "path" => ["/club/dashboard/election", "/club/dashboard/election/vote", "/club/dashboard/election/result"], "active" => "false"]);
        }
        if (in_array($club_role, ['CLUB_IN_CHARGE', 'PRESIDENT', 'SECRETARY', 'TREASURER'])) {
            array_push($menu, ["id" => "logs", "name" => "Logs", "icon" => "article", "path" => "/club/dashboard/logs", "active" => "false"], ["id" => "members", "name" => "Members", "icon" => "people", "path" => "/club/dashboard/members", "active" => "false"],);
        }
        if (in_array($club_role, ['CLUB_IN_CHARGE', 'PRESIDENT', 'SECRETARY'])) {
            array_push($menu, ["id" => "reports", "name" => "Reports", "icon" => "description", "path" => ["/club/dashboard/reports", "/club/dashboard/reports/add"], "active" => "false"], ["id" => "meetings", "name" => "Meetings", "icon" => "diversity_2", "path" => "/club/dashboard/meetings", "active" => "false"]);
        }
        if (in_array($club_role, ['CLUB_IN_CHARGE', 'PRESIDENT'])) {
            array_push($menu, ["id" => "election", "name" => "Election", "icon" => "how_to_vote", "path" => ["/club/dashboard/election", "/club/dashboard/election/add", "/club/dashboard/election/edit", "/club/dashboard/election/vote", "/club/dashboard/election/result"], "active" => "false"], ["id" => "requests", "name" => "Requests", "icon" => "crisis_alert", "path" => ["/club/dashboard/requests", "/club/dashboard/requests/add"], "active" => "false"]);
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
        $event_budgets = new BudgetLimits($db);
        $event_group = new EventGroup($db);
        $event_group_member = new EventGroupMember($db);

        $storage = new Storage();
        $club_id = $storage->get('club_id');

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
                                    } catch (\Throwable $th) {
                                        throw new Error("Failed to add member to event " . $group['name'] . " group");
                                    }
                                }
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
                }

                $data['errors'] = $event->errors;
                if (count($group_errors) > 0) {
                    $data['errors']['groups'] = $group_errors;
                }
            }

            $db->commit();

            if ($_SERVER['REQUEST_METHOD'] == "POST") return redirect($redirect_link);
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
            $event_budget_data = $event_budgets->find(
                ["club_event_id" => $club_event_id],
            );
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
        $total_count = $event->find([
            "club_id" => $club_id
        ], ["count(*) as count"], [], [], isset($_GET['search']) ? $_GET['search'] : '');
        if (!empty($total_count[0]->count)) $data['total_count'] = $total_count[0]->count;

        /* fetch events */
        $data['events_data'] = $event->find(["club_id" => $club_id], [], [], [
            "limit" => $data['limit'],
            "offset" => ($data['page'] - 1) * $data['limit'],
        ], isset($_GET['search']) ? $_GET['search'] : '');

        $this->view($path, $data);
    }

    private function budgets($path, $data)
    {
        $db = new Database();
        $event = new Event($db);
        $budget_limits = new BudgetLimits($db);

        $storage = new Storage();
        $club_id = $storage->get('club_id');
        $club_event_id = $storage->get('club_event_id');

        $data['total_count'] = 0;
        $data['limit'] = 10;
        $data['page'] = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

        $redirect_link = null;

        if (empty($club_id))  $_SESSION['alerts'] = [["status" => "error", "message" => "Club details are not found"]];

        try {
            $db->transaction();

            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                $form_data = $_POST;

                $budget_errors = [];

                if ($form_data['submit'] == 'update_budget') {
                    $form_data['club_id'] = $club_id;
                    $form_data['club_event_id'] = $club_event_id;
                    $budget_limits->delete(["club_event_id" => $club_event_id, "club_id" => $club_id]);

                    foreach ($form_data['budgets'] as $key => $budget) {
                        if ($budget_limits->validateAddBudget($budget)) {
                            try {
                                $budget_limits->create([
                                    "name" => $budget['name'],
                                    "club_id" => $form_data['club_id'],
                                    "club_event_id" => $form_data['club_event_id'],
                                    "amount" => $budget['amount'],
                                    "description" => isset($budget['description']) ? $budget['description'] : '',

                                ]);
                            } catch (\Throwable $th) {
                                throw new Error("Failed to create a budget: " . $budget['name']);
                            }
                        }

                        if (count($budget_limits->errors) > 0) {
                            $budget_errors[$key] = $budget_limits->errors;
                        } else {
                            $event->update([
                                "id" => $club_event_id
                            ], [
                                "is_budgets_verified" => 1
                            ]);

                            $_SESSION['alerts'] = [["status" => "success", "message" => "Updated event budgets successfully"]];
                            $redirect_link = 'club/dashboard/budgets';
                        }
                    }
                } else if ($_POST['submit'] == 'budget-redirect') {
                    $storage = new Storage();
                    $storage->set('club_event_id', $_POST['club_event_id']);

                    return redirect('club/dashboard/budgets/edit');
                }

                $data['errors'] = $event->errors;
                if (count($budget_errors) > 0) {
                    $data['errors']['budgets'] = $budget_errors;
                }
            }

            $db->commit();

            if ($_SERVER['REQUEST_METHOD'] == "POST") return redirect($redirect_link);
        } catch (\Throwable $th) {
            $db->rollback();
            $_SESSION['alerts'] = [["status" => "error", "message" => $th->getMessage() || "Failed to process the action, please try again later."]];
        }

        /* fetch club members */
        if ($path == 'club/dashboard/budgets/edit') {
            /* set event data */
            $data['event_data'] = $event->one(
                ["id" => $club_event_id],
                [
                    "id",
                    "name",
                    "venue",
                    "start_datetime",
                    "end_datetime",
                    "description",
                ]
            );

            /* set event budget limits */
            $event_budget_data = $budget_limits->find(
                ["club_event_id" => $club_event_id],
            );
            foreach ($event_budget_data as $budget_id => $budget) {
                $_POST['budgets'][$budget_id] = [
                    "id" => $budget->id,
                    "name" => $budget->name,
                    "amount" => $budget->amount,
                    "description" => $budget->description,
                ];
            }
        } else {
            /* pagination */
            $total_count = $event->find([
                "club_id" => $club_id,
            ], ["count(*) as count"], [], [], isset($_GET['search']) ? $_GET['search'] : '');
            if (!empty($total_count[0]->count)) $data['total_count'] = $total_count[0]->count;

            /* fetch events */
            $data['events_data'] = $event->find(["club_id" => $club_id], [], [], [
                "limit" => $data['limit'],
                "offset" => ($data['page'] - 1) * $data['limit'],
            ], isset($_GET['search']) ? $_GET['search'] : '');
        }


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
        $this->view($path, $data);
    }

    private function community($path, $data)
    {
        $this->view($path, $data);
    }

    private function requests($path, $data)
    {
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

        $storage = new Storage();
        $club_id = $storage->get('club_id');
        $redirect_on_success = true;

        $tabs = ['votes', 'elections'];
        $data["tab"] = getActiveTab($tabs, $_GET);

        $data['total_count'] = 0;
        $data['limit'] = 10;
        $data['page'] = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

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

                        /* add candidates */
                        if (!empty($form_data['candidate']) && is_array($form_data['candidate'])) {
                            foreach ($form_data['candidate'] as $candidate) {
                                $club_election_candidates->create([
                                    "club_id" => $form_data['club_id'],
                                    "user_id" => $candidate['user_id'],
                                    "club_member_id" => $candidate['id'],
                                    "election_id" => $club_election_result->id
                                ]);
                            }
                        }

                        /* add voters */
                        if (!empty($form_data['voter']) && is_array($form_data['voter'])) {
                            foreach ($form_data['voter'] as $voter) {
                                $club_election_voters->create([
                                    "club_id" => $form_data['club_id'],
                                    "user_id" => $voter['user_id'],
                                    "club_member_id" => $voter['id'],
                                    "election_id" => $club_election_result->id
                                ]);
                            }
                        }
                    }

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

                        /* add candidates */
                        if (!empty($form_data['candidate']) && is_array($form_data['candidate'])) {
                            foreach ($form_data['candidate'] as $candidate) {
                                $club_election_candidates->create([
                                    "club_id" => $form_data['club_id'],
                                    "user_id" => $candidate['user_id'],
                                    "club_member_id" => $candidate['id'],
                                    "election_id" => $form_data['id']
                                ]);
                            }
                        }

                        /* add voters */
                        if (!empty($form_data['voter']) && is_array($form_data['voter'])) {
                            foreach ($form_data['voter'] as $voter) {
                                $club_election_voters->create([
                                    "club_id" => $form_data['club_id'],
                                    "user_id" => $voter['user_id'],
                                    "club_member_id" => $voter['id'],
                                    "election_id" => $form_data['id']
                                ]);
                            }
                        }
                    }

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
                    $user_id = Auth::getId();
                    if (empty($_GET["election"])) return redirect('not-found');

                    $election_voter = $club_election_voters->one(["user_id" => $user_id, "election_id" => $_GET['election']]);
                    if (empty($election_voter)) return redirect('not-found');


                    if ($club_election_vote->validateCreate($form_data)) {
                        /* updated election voter state */
                        $club_election_voters->update([
                            "id" => $election_voter->id
                        ], [
                            "did_vote" => 1
                        ]);

                        /* add president vote */
                        $club_election_vote->create([
                            "role" => "PRESIDENT",
                            "club_id" => $form_data['club_id'],
                            "club_election_id" => $form_data['club_election_id'],
                            "voter_id" => $election_voter->id,
                            "selected_candidate_id" => $form_data['president'],
                            "description" => empty($form_data['president_description']) ? '' : $form_data['president_description'],
                        ]);
                        /* add secretory vote */
                        $club_election_vote->create([
                            "role" => "SECRETORY",
                            "club_id" => $form_data['club_id'],
                            "club_election_id" => $form_data['club_election_id'],
                            "voter_id" => $election_voter->id,
                            "selected_candidate_id" => $form_data['secretory'],
                            "description" => empty($form_data['secretory_description']) ? '' : $form_data['secretory_description'],
                        ]);
                        /* add treasurer vote */
                        $club_election_vote->create([
                            "role" => "TREASURER",
                            "club_id" => $form_data['club_id'],
                            "club_election_id" => $form_data['club_election_id'],
                            "voter_id" => $election_voter->id,
                            "selected_candidate_id" => $form_data['treasurer'],
                            "description" => empty($form_data['treasurer_description']) ? '' : $form_data['treasurer_description'],
                        ]);
                    }

                    $data["errors"] = $club_election_vote->errors;

                    $redirect_on_success = false;

                    $_SESSION['alerts'] = [["status" => "success", "message" => "Election voted successfully"]];
                }
            }

            if ($path == 'club/dashboard/election/add' || $path == 'club/dashboard/election/edit') {
                $data['vote_members_data']  = $data['candidate_members_data'] = $club_member->find(
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
            /* fetch election data for the form */
            if ($path == 'club/dashboard/election/edit') {
                if (empty($_GET['id'])) {
                    return redirect('not-found');
                }

                $election_data = $club_election->one(
                    ["club_id" => $club_id, "id" => $_GET['id']]
                );

                /* if the election is opened or closed do not let them edit */
                if ($election_data->state !== 'PENDING') {
                    return redirect('not-found');
                }

                $_POST['id'] = $election_data->id;
                $_POST['title'] = $election_data->title;
                $_POST['description'] = $election_data->description;
                $_POST['start_datetime'] = $election_data->start_datetime;
                $_POST['end_datetime'] = $election_data->end_datetime;

                /* election candidates */
                $_POST['candidate'] = $club_election_candidates->find([
                    "election_id" => $_GET['id']
                ], [
                    "club_election_candidates.id",
                    "club_election_candidates.user_id",
                    "club_election_candidates.club_id",
                    "concat(user.first_name,' ', user.last_name) as name",
                ], [
                    ["table" => "users", "as" => "user", "on" => "club_election_candidates.user_id = user.id"]
                ], ["type" => "array"]);

                /* election voters */
                $_POST['voter'] = $club_election_voters->find([
                    "election_id" => $_GET['id']
                ], [
                    "club_election_voters.id",
                    "club_election_voters.user_id",
                    "club_election_voters.club_id",
                    "concat(user.first_name,' ', user.last_name) as name",
                ], [
                    ["table" => "users", "as" => "user", "on" => "club_election_voters.user_id = user.id"]
                ], ["type" => "array"]);
            }
            /* election vote data */
            if ($path == 'club/dashboard/election/vote') {
                $user_id = Auth::getId();
                if (empty($_GET["election"])) return redirect('not-found');

                /* get election details */
                $election_id = $_GET["election"];
                $data['election'] = $club_election->one(["id" => $election_id]);

                /* get election voter details */
                $election_voter = $club_election_voters->one(["user_id" => $user_id, "election_id" => $_GET['election']]);
                if (empty($election_voter)) return redirect('not-found');

                $data['candidate_members_data'] = $club_election_candidates->find(
                    ["club_id" => $club_id, "election_id" => $_GET["election"]],
                    [
                        "club_election_candidates.id as id",
                        "club_election_candidates.club_member_id as club_member_id",
                        "club_election_candidates.user_id",
                        "club_election_candidates.club_id",
                        "user.first_name",
                        "user.last_name",
                    ],
                    [
                        ["table" => "users", "as" => "user", "on" => "club_election_candidates.user_id = user.id"]
                    ]
                );

                $redirect_on_success = false;
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
                    "voter.user_id" => $user_id
                ], [
                    "club_elections.id",
                    "club_elections.title",
                    "club_elections.start_datetime",
                    "club_elections.end_datetime",
                    "club_elections.description",
                ], [
                    ["table" => "club_election_voters", "as" => "voter", "on" => "club_elections.id = voter.election_id"]
                ], [
                    "limit" => $data['limit'],
                    "offset" => ($data['page'] - 1) * $data['limit'],
                ], isset($_GET['search']) ? $_GET['search'] : '');
            } else {
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

            $db->commit();

            if ($redirect_on_success && $_SERVER['REQUEST_METHOD'] == "POST" &&  count($data['errors']) == 0) return redirect('club/dashboard/election');
        } catch (\Throwable $th) {
            $db->rollback();
            $_SESSION['alerts'] = [["status" => "error", "message" => $th->getMessage() || "Failed to process the action, please try again later."]];
        }

        $this->view($path, $data);
    }
}
