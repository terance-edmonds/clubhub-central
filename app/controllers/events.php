<?php

class Events extends Controller
{
    public function index()
    {
        $left_bar = [
            "calendar_data" => [
                "current_path" => "/"
            ]
        ];

        $data = [
            "left_bar" => $left_bar
        ];

        $this->view("events", $data);
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
            "popups" => [],
            "alerts" => [],
            "errors" => [],
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
        $tabs = ['income', 'expense'];
        $tab = $tabs[0];

        if (!empty($_GET['tab'])) {
            $tab = in_array($_GET['tab'], $tabs) ? $_GET['tab'] : $tabs[0];
        }

        $data["tab"] = $tab;

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $storage = new Storage();
            $budget = new Budget();
            $form_data = $_POST;

            if ($_POST['submit'] = "add-income") {
                $club_id = $storage->get('club_id');
                $club_event_id = $storage->get('club_event_id');

                /* remove these */
                $club_id = 1;
                $club_event_id = 1;

                if (empty($club_id))  $_SESSION['alerts'] = [["status" => "error", "message" => "Club details are not found"]];
                else if (empty($club_event_id))  $_SESSION['alerts'] = [["status" => "error", "message" => "Event details are not found"]];
                else {
                    $form_data['club_id'] = $club_id;
                    $form_data['club_event_id'] = $club_event_id;

                    if ($budget->validateAddIncome($form_data)) {
                        try {
                            $budget->create($form_data);

                            $_SESSION['alerts'] = [["status" => "success", "message" => "Income budget details added successfully"]];

                            redirect();
                        } catch (Throwable $th) {
                            $_SESSION['alerts'] = [["status" => "error", "message" => "Failed to add budget details"]];
                        }
                    } else {
                        $data['popups']["add-income"] = true;
                    }

                    $data['errors'] = $budget->errors;
                }
            }
        }

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
