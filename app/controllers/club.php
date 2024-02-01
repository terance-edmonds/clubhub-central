<?php

use function _\upperCase;

class Club extends Controller
{
    public function index()
    {
        $left_bar = [
            "calendar_data" => [
                "current_path" => "/"
            ]
        ];
        $right_bar = [
            "clubs" => []
        ];

        $data = [
            "tab" => "club-posts",
            "club_id" => "",
            "left_bar" => $left_bar,
            "right_bar" => $right_bar
        ];
        $params = $_GET;

        if (isset($params["id"])) $data["club_id"] = $params["id"];
        if (isset($params["tab"])) $data["tab"] = $params["tab"];

        $this->view("club", $data);
    }

    public function dashboard()
    {
        $storage = new Storage();
        $path = $_GET["url"];
        $func = "view";

        $club_id = $storage->get('club_id');
        $club_role = $storage->get('club_role');

        if (empty($club_id)) {
            return redirect('not-found');
        }

        $menu = [
            ["id" => "events", "name" => "Events", "icon" => "emoji_events", "path" => ["/club/dashboard", "/club/dashboard/events/add"], "active" => "false"],
            ["id" => "posts", "name" => "Posts", "icon" => "history_edu", "path" => ["/club/dashboard/posts", "/club/dashboard/posts/add", "/club/dashboard/posts/edit"], "active" => "false"],
            ["id" => "community", "name" => "Community Chat", "icon" => "mark_unread_chat_alt", "path" => "/club/dashboard/community", "active" => "false"],
        ];

        /* filter menu */
        if (in_array($club_role, ['CLUB_IN_CHARGE', 'PRESIDENT', 'SECRETARY', 'TREASURER'])) {
            array_push($menu, ["id" => "logs", "name" => "Logs", "icon" => "article", "path" => "/club/dashboard/logs", "active" => "false"], ["id" => "members", "name" => "Members", "icon" => "people", "path" => "/club/dashboard/members", "active" => "false"],);
        }
        if (in_array($club_role, ['CLUB_IN_CHARGE', 'PRESIDENT', 'SECRETARY'])) {
            array_push($menu, ["id" => "reports", "name" => "Reports", "icon" => "description", "path" => ["/club/dashboard/reports", "/club/dashboard/reports/add"], "active" => "false"], ["id" => "meetings", "name" => "Meetings", "icon" => "diversity_2", "path" => "/club/dashboard/meetings", "active" => "false"]);
        }
        if (in_array($club_role, ['CLUB_IN_CHARGE', 'PRESIDENT'])) {
            array_push($menu, ["id" => "election", "name" => "Election", "icon" => "how_to_vote", "path" => ["/club/dashboard/election", "/club/dashboard/election/add"], "active" => "false"]);
        }
        if (in_array($club_role, ['CLUB_IN_CHARGE'])) {
            array_push($menu, ["id" => "requests", "name" => "Requests", "icon" => "crisis_alert", "path" => ["/club/dashboard/requests", "/club/dashboard/requests/add"], "active" => "false"]);
        }

        /* update the active menu item */
        $func = getActiveMenu($menu, $path);

        $data = [
            "menu" => $menu,
            "club_role" => $club_role
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

        $storage = new Storage();
        $club_id = $storage->get('club_id');

        $redirect_link = null;

        if (empty($club_id))  $_SESSION['alerts'] = [["status" => "error", "message" => "Club details are not found"]];

        try {
            $db->transaction();

            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                $form_data = $_POST;

                if ($form_data['submit'] == 'create_event') {
                    $form_data['club_id'] = $club_id;

                    $group_errors = [];
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
                } else if ($_POST['submit'] == 'event-redirect') {
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
        if ($path == 'club/dashboard/event/add') {
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

        /* fetch events */
        $data['events_data'] = $event->find(["club_id" => $club_id], [], [], [], isset($_GET['search']) ? $_GET['search'] : '');

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
            show($th);
            $_SESSION['alerts'] = [["status" => "error", "message" => $th->getMessage() || "Failed to process the action, please try again later."]];
            return redirect($redirect);
        }


        $this->view($path, $data);
    }

    private function logs($path, $data)
    {
        $tabs = ['posts', 'budgets'];
        $data["tab"] = getActiveTab($tabs, $_GET);

        $this->view($path, $data);
    }
    private function election($path, $data)
    {
        $this->view($path, $data);
    }
}
