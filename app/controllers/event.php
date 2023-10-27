<?php

class Event extends Controller
{
    public function index()
    {
        $data = [
            "tab" => "sponsers",
            "club_id" => ""
        ];
        $params = $_GET;

        if (isset($params["id"])) $data["club_id"] = $params["id"];
        if (isset($params["tab"])) $data["tab"] = $params["tab"];

        $this->view("event", $data);
    }


    

    public function dashboard()
    {
        $path = $_GET["url"];
        $menu_data = [
            "menu" => [
                ["id" => "eventDetails", "name" => "Event Details", "icon" => "emoji_events", "path" => "/event/dashboard"],
                ["id" => "registraions", "name" => "registrations", "icon" => "diversity_2", "path" => "/event/dashboard/registrations"],
                ["id" => "sponsers", "name" => "Sponsers", "icon" => "diversity_2", "path" => "/event/dashboard/sponsers"],
                ["id" => "budgets", "name" => "Budgets", "icon" => "diversity_2", "path" => "/event/dashboard/budgets"],
                ["id" => "agendas", "name" => "Agendas", "icon" => "diversity_2", "path" => "/event/dashboard/agendas"],
                ["id" => "notifications", "name" => "Notifications", "icon" => "diversity_2", "path" => "/event/dashboard/Notifications"],
                ["id" => "complaints", "name" => "Complaints", "icon" => "diversity_2", "path" => "/event/dashboard/complaints"]
                
            ]
        ];
        $data = [
            "menu_data" => $menu_data
        ];

        $this->view($path, $data);
    }
}
