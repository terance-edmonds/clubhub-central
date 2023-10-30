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
            ["id" => "agenda", "name" => "Agenda", "icon" => "view_agenda", "path" => "/events/dashboard/agenda", "active" => "false"],
            ["id" => "notifications", "name" => "Notifications", "icon" => "notifications", "path" => "/events/dashboard/Notifications", "active" => "false"],
            ["id" => "complains", "name" => "Complaints", "icon" => "inbox", "path" => "/events/dashboard/complains", "active" => "false"]

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
        function packages($path, $data)
        {
        }
        $this->view($path, $data);
    }

    private function packages($path, $data){
        $storage = new Storage();
        $package = new Package();

        $club_id = $storage->get('club_id');
        $club_event_id = $storage->get('club_event_id');

        $club_id = 1;
        $club_event_id = 1;

        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $form_data = $_POST;

            if ($_POST['submit'] == "add-package") {
                if (empty($club_id))  $_SESSION['alerts'] = [["status" => "error", "message" => "Club details are not found"]];
                else if (empty($club_event_id))  $_SESSION['alerts'] = [["status" => "error", "message" => "Event details are not found"]];
                else {
                    $form_data['club_id'] = $club_id;
                    $form_data['club_event_id'] = $club_event_id;

                    if ($package->validateCreatePackage($form_data)) {
                        try {
                            $package->create($form_data);

                            $_SESSION['alerts'] = [["status" => "success", "message" => "Package details added successfully"]];

                            redirect();
                        } catch (Throwable $th) {
                            $_SESSION['alerts'] = [["status" => "error", "message" => "Failed to add package details"]];
                        }
                    } else {
                        $data['popups']["add-package"] = true;
                    }

                    $data['errors'] = $package->errors;
                }
            }
            else if ($_POST['submit'] == "edit-package") {
                $where['id'] = $form_data['id'];

                if ($package->validateEditPackage($form_data)) {
                    try {
                        $package->update($where, $form_data);

                        $_SESSION['alerts'] = [["status" => "success", "message" => "Package details updated successfully"]];

                        redirect();
                    } catch (Throwable $th) {
                        $_SESSION['alerts'] = [["status" => "error", "message" => "Failed to update package details"]];
                    }
                } else {
                    $data['popups']["edit-package"] = $form_data;
                }

                $data['errors'] = $package->errors;
            }
            else if ($_POST['submit'] == "delete-package") {
                try {
                    $package->delete(["id" => $form_data['id']]);

                    $_SESSION['alerts'] = [["status" => "success", "message" => "Package details deleted successfully"]];

                    redirect();
                } catch (Throwable $th) {
                    var_dump($th);
                    $_SESSION['alerts'] = [["status" => "error", "message" => "Failed to delete Package details"]];
                }

                $data['errors'] = $package->errors;
            }


        }
        $data["income_data"] = $package->find(["club_id" => $club_id, "club_event_id" => $club_event_id]);
       
    }

    private function budgets($path, $data)
    {
        $tabs = ['income', 'expense'];
        $tab = $tabs[0];
        if (!empty($_GET['tab'])) {
            $tab = in_array($_GET['tab'], $tabs) ? $_GET['tab'] : $tabs[0];
        }
        $data["tab"] = $tab;

        $storage = new Storage();
        $budget = new Budget();

        $club_id = $storage->get('club_id');
        $club_event_id = $storage->get('club_event_id');

        /* remove these on production */
        $club_id = 1;
        $club_event_id = 1;

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $form_data = $_POST;

            if ($_POST['submit'] == "add-income") {
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
            } else if ($_POST['submit'] == "edit-income") {
                $where['id'] = $form_data['id'];

                if ($budget->validateEditIncome($form_data)) {
                    try {
                        $budget->update($where, $form_data);

                        $_SESSION['alerts'] = [["status" => "success", "message" => "Income budget details updated successfully"]];

                        redirect();
                    } catch (Throwable $th) {
                        $_SESSION['alerts'] = [["status" => "error", "message" => "Failed to update budget details"]];
                    }
                } else {
                    $data['popups']["edit-income"] = $form_data;
                }

                $data['errors'] = $budget->errors;
            } else if ($_POST['submit'] == "delete-income") {
                try {
                    $budget->delete(["id" => $form_data['id']]);

                    $_SESSION['alerts'] = [["status" => "success", "message" => "Income budget details deleted successfully"]];

                    redirect();
                } catch (Throwable $th) {
                    $_SESSION['alerts'] = [["status" => "error", "message" => "Failed to delete budget details"]];
                }

                $data['errors'] = $budget->errors;
            }
        }

        /* fetch results */
        $data["income_data"] = $budget->find(["club_id" => $club_id, "club_event_id" => $club_event_id]);

        $this->view($path, $data);
    }

    private function agenda($path, $data)
    {
        $this->view($path, $data);
    }

    private function notifications($path, $data)
    {
        $this->view($path, $data);
    }

    private function complains($path, $data)
    {
        $this->view($path, $data);
    }
}
