<?php

use function _\upperCase;

class Club extends Controller
{
    public function index()
    {
        $data = [
            "tab" => "club-posts",
            "club_id" => ""
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
        $type = "accepted";
        if (!empty($_GET["type"])) $type = $_GET["type"];
        $data["type"] = upperCase($type);

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
}
