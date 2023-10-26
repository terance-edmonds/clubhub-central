<?php

class Events extends Controller
{
    public function index()
    {
        $this->view("events");
    }

    public function event()
    {
        $this->view("events/event");
    }

    public function dashboard()
    {
        $path = $_GET["url"];
        $menu_data = [
            "menu" => [
                ["id" => "eventDetails", "name" => "Event Details", "icon" => "emoji_events", "path" => "/events/event/dashboard"],
                ["id" => "sponsers", "name" => "Sponsers", "icon" => "diversity_2", "path" => "/events/event/sponsers"]
                
            ]
        ];
        $data = [
            "menu_data" => $menu_data
        ];

        $this->view($path, $data);
    }
}
