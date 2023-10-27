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
        /* use outlined icons */
        $menu_data = [
            "menu" => [
                ["id" => "events", "name" => "Event Details", "icon" => "info", "path" => "/events/dashboard"],
                ["id" => "registrations", "name" => "registrations", "icon" => "app_registration", "path" => "/events/dashboard/registrations"],
                ["id" => "sponsors", "name" => "Sponsors", "icon" => "diversity_3", "path" => "/events/dashboard/sponsors"],
                ["id" => "budgets", "name" => "Budgets", "icon" => "monetization_on", "path" => "/events/dashboard/budgets"],
                ["id" => "agendas", "name" => "Agendas", "icon" => "view_agenda", "path" => "/events/dashboard/agendas"],
                ["id" => "notifications", "name" => "Notifications", "icon" => "notifications", "path" => "/events/dashboard/Notifications"],
                ["id" => "complaints", "name" => "Complaints", "icon" => "inbox", "path" => "/events/dashboard/complaints"]

            ]
        ];
        $data = [
            "menu_data" => $menu_data
        ];

        $this->view($path, $data);
    }
}
