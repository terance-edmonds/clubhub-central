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
        $path = $_GET["url"];
        $func = "view";

        $menu = [
            ["id" => "events", "name" => "Events", "icon" => "emoji_events", "path" => "/club/dashboard", "active" => "false"],
            ["id" => "members", "name" => "Members", "icon" => "people", "path" => "/club/dashboard/members", "active" => "false"],
            ["id" => "meetings", "name" => "Meetings", "icon" => "diversity_2", "path" => "/club/dashboard/meetings", "active" => "false"],
            ["id" => "reports", "name" => "Reports", "icon" => "description", "path" => "/club/dashboard/reports", "active" => "false"],
            ["id" => "community", "name" => "Community Chat", "icon" => "mark_unread_chat_alt", "path" => "/club/dashboard/community", "active" => "false"],
            ["id" => "requests", "name" => "Requests", "icon" => "crisis_alert", "path" => "/club/dashboard/requests", "active" => "false"],
            ["id" => "posts", "name" => "Posts", "icon" => "history_edu", "path" => "/club/dashboard/posts", "active" => "false"],
            ["id" => "logs", "name" => "Logs", "icon" => "article", "path" => "/club/dashboard/logs", "active" => "false"],
            ["id" => "election", "name" => "Election", "icon" => "how_to_vote", "path" => "/club/dashboard/election", "active" => "false"],
        ];
        /* update the active menu item */
        foreach ($menu as $x => &$val) {
            if ($val["path"] == "/" . $path) {
                $func = $val["id"];
                $val["active"] = 'true';
            }
        }

        $data = [
            "menu" => $menu
        ];

        $this->$func($path, $data);
    }

    private function events($path, $data)
    {
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
    private function election($path, $data){
        $this->view($path,$data);
    }
}
