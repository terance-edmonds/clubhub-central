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
        $func = "view";

        /* use outlined icons */
        $menu = [
            ["id" => "events", "name" => "Event Details", "icon" => "info", "path" => "/events/dashboard", "active" => "false"],
            ["id" => "registrations", "name" => "registrations", "icon" => "app_registration", "path" => "/events/dashboard/registrations", "active" => "false"],
            ["id" => "sponsors", "name" => "Sponsors", "icon" => "diversity_3", "path" => "/events/dashboard/sponsors", "active" => "false"],
            ["id" => "budgets", "name" => "Budgets", "icon" => "monetization_on", "path" => "/events/dashboard/budgets", "active" => "false"],
            ["id" => "agendas", "name" => "Agendas", "icon" => "view_agenda", "path" => "/events/dashboard/agendas", "active" => "false"],
            ["id" => "notifications", "name" => "Notifications", "icon" => "notifications", "path" => "/events/dashboard/Notifications", "active" => "false"],
            ["id" => "complaints", "name" => "Complaints", "icon" => "inbox", "path" => "/events/dashboard/complaints", "active" => "false"]

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

    private function registrations($path, $data)
    {
        $this->view($path, $data);
    }

    private function sponsors($path, $data)
    {
        $this->view($path, $data);
    }

    private function budgets($path, $data)
    {
        $this->view($path, $data);
    }

    private function agendas($path, $data)
    {
        $this->view($path, $data);
    }

    private function notifications($path, $data)
    {
        $this->view($path, $data);
    }

    private function complaints($path, $data)
    {
        $this->view($path, $data);
    }
}
