<?php

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
        $menu_data = [
            "menu" => [
                ["id" => "events", "name" => "Events", "icon" => "emoji_events", "path" => "/club/dashboard"],
                ["id" => "members", "name" => "Members", "icon" => "people", "path" => "/club/dashboard/members"],
                ["id" => "meetings", "name" => "Meetings", "icon" => "diversity_2", "path" => "/club/dashboard/meetings"],
                ["id" => "reports", "name" => "Reports", "icon" => "description", "path" => "/club/dashboard/reports"],
                ["id" => "community", "name" => "Community Chat", "icon" => "mark_unread_chat_alt", "path" => "/club/dashboard/community"],
            ]
        ];
        $data = [
            "menu_data" => $menu_data
        ];

        $this->view($path, $data);
    }
}
