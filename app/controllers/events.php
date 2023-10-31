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

    private function budgets($path, $data)
    {
        $tabs = ['income', 'expense'];
        $data["tab"] = getActiveTab($tabs, $_GET);

        $storage = new Storage();
        $db = new Database();
        $budget = new Budget($db);
        $budget_log = new BudgetLogs($db);

        $club_id = $storage->get('club_id');
        $club_event_id = $storage->get('club_event_id');
        $club_member_id = $storage->get('club_member_id');
        $user_id = Auth::getId();

        /* remove these on production */
        $club_id = 1;
        $club_event_id = 1;
        $club_member_id = 1;

        if (empty($club_id))  $_SESSION['alerts'] = [["status" => "error", "message" => "Club details are not found"]];
        if (empty($club_event_id))  $_SESSION['alerts'] = [["status" => "error", "message" => "Event details are not found"]];

        try {
            $db->transaction();

            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                $form_data = $_POST;
                $budget_log_data = [
                    "club_id" => $club_id,
                    "user_id" => $user_id,
                    "club_event_id" => $club_event_id,
                    "club_member_id" => $club_member_id,
                    "club_event_budget_id" => "",
                    "type" => "",
                    "description" => ""
                ];

                if ($_POST['submit'] == "add-income") {
                    $budget_log_data["type"] = "INCOME";
                    $budget_log_data["description"] = "Added a new budget income.";
                    $form_data['club_id'] = $club_id;
                    $form_data['club_event_id'] = $club_event_id;

                    if ($budget->validateAddIncome($form_data)) {
                        try {
                            $result = $budget->create($form_data);
                            if (!empty($result)) {
                                $budget_log_data["club_event_budget_id"] = $result->id;
                                $budget_log->create($budget_log_data);
                            }

                            $_SESSION['alerts'] = [["status" => "success", "message" => "Income budget details added successfully"]];
                        } catch (Throwable $th) {
                            var_dump($th);
                            $_SESSION['alerts'] = [["status" => "error", "message" => "Failed to add budget details"]];
                        }
                    } else {
                        $data['popups']["add-income"] = true;
                    }

                    $data['errors'] = $budget->errors;
                } else if ($_POST['submit'] == "edit-income") {
                    $budget_log_data["type"] = "INCOME";
                    $budget_log_data["description"] = "Updated budget income details.";
                    $budget_log_data["club_event_budget_id"] = $form_data['id'];
                    $where['id'] = $form_data['id'];

                    if ($budget->validateEditIncome($form_data)) {
                        try {
                            $budget->update($where, $form_data);
                            $budget_log->create($budget_log_data);

                            $_SESSION['alerts'] = [["status" => "success", "message" => "Income budget details updated successfully"]];
                        } catch (Throwable $th) {
                            $_SESSION['alerts'] = [["status" => "error", "message" => "Failed to update budget details"]];
                        }
                    } else {
                        $data['popups']["edit-income"] = $form_data;
                    }

                    $data['errors'] = $budget->errors;
                } else if ($_POST['submit'] == "delete-income") {
                    try {
                        $budget_log_data["type"] = "INCOME";
                        $budget_log_data["description"] = "Deleted budget income details.";
                        $budget_log_data["club_event_budget_id"] = $form_data['id'];

                        /* delete the item */
                        // $budget_log->delete(["club_event_budget_id" => $form_data['id']]);
                        // $budget->delete(["id" => $form_data['id']]);

                        /* set the state as deleted */
                        $budget->update(["id" => $form_data['id']], ["is_deleted" => 1]);
                        $budget_log->create($budget_log_data);

                        $_SESSION['alerts'] = [["status" => "success", "message" => "Income budget details deleted successfully"]];
                    } catch (Throwable $th) {
                        var_dump($th);
                        $_SESSION['alerts'] = [["status" => "error", "message" => "Failed to delete budget details"]];
                    }

                    $data['errors'] = $budget->errors;
                }

                redirect();
            }

            $data["income_data"] = $budget->find(["club_id" => $club_id, "club_event_id" => $club_event_id, "is_deleted" => 0]);
        } catch (\Throwable $th) {
            $data['errors'] = "Failed to proceed the action, please try again later.";
            $db->rollback();
        }

        /* fetch results */
        $db->commit();

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
