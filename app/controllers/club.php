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
            redirect('/not-found');
        }

        $menu = [
            ["id" => "events", "name" => "Events", "icon" => "emoji_events", "path" => ["/club/dashboard", "/club/dashboard/events/add"], "active" => "false"],
            ["id" => "community", "name" => "Community Chat", "icon" => "mark_unread_chat_alt", "path" => "/club/dashboard/community", "active" => "false"],
            ["id" => "posts", "name" => "Posts", "icon" => "history_edu", "path" => ["/club/dashboard/posts", "/club/dashboard/posts/add"], "active" => "false"],
        ];

        /* filter menu */
        if (in_array($club_role, ['CLUB_IN_CHARGE', 'PRESIDENT', 'SECRETORY', 'TREASURER'])) {
            array_push($menu, ["id" => "logs", "name" => "Logs", "icon" => "article", "path" => "/club/dashboard/logs", "active" => "false"], ["id" => "members", "name" => "Members", "icon" => "people", "path" => "/club/dashboard/members", "active" => "false"],);
        }
        if (in_array($club_role, ['CLUB_IN_CHARGE', 'PRESIDENT', 'SECRETORY'])) {
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
        $storage = new Storage();
        $event = new Event($db);
        $event_group = new EventGroup($db);
        $event_group_member = new EventGroupMember($db);

        $db->transaction();

        try {
            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                $form_data = $_POST;

                $club_id = $storage->get('club_id');

                show($form_data);
                if ($form_data['submit'] == 'create_event') {
                    if (empty($club_id))  $_SESSION['alerts'] = [["status" => "error", "message" => "Club details are not found"]];
                    else {
                        $form_data['club_id'] = $club_id;

                        if ($event->validateCreateEvent($form_data)) {
                            try {
                                $event->create([
                                    "name" => $form_data['name'],
                                    "venue" => $form_data['venue'],
                                    "start_datetime" => $form_data['start_datetime'],
                                    "end_datetime" => $form_data['end_datetime'],
                                    "created_datetime" => $form_data['created_datetime'],
                                    "description" => $form_data['description']
                                ]);

                                $_SESSION['alerts'] = [["status" => "success", "message" => "Created an event successfully"]];
                            } catch (\Throwable $e) {
                                throw new Error("Failed to create an event");
                            }
                        }
                    }
                }
            }

            $data['errors'] = $event->errors;

            $db->commit();

            // if ($_SERVER['REQUEST_METHOD'] == "POST") redirect();
        } catch (\Throwable $e) {
            $_SESSION['alerts'] = [["status" => "error", "message" => $e->getMessage() || "Failed to process the action, please try again later."]];
            $db->rollback();
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
