<?php

use function _\upperCase;

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
            ["id" => "announcements", "name" => "Announcement", "icon" => "campaign", "path" => "/events/dashboard/announcements", "active" => "false"],
            ["id" => "complains", "name" => "Complaints", "icon" => "inbox", "path" => "/events/dashboard/complains", "active" => "false"]

        ];
        /* update the active menu item */
        $func = getActiveMenu($menu, $path);

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
        $event = new Event();
        $event_group = new EventGroup();
        $storage = new Storage();

        $club_id = $storage->get('club_id');
        $club_event_id = $storage->get('club_event_id');


        $event_data = $event->one(["id" => $club_event_id, "club_id" => $club_id]);
        /* set event details */
        $_POST['name'] = $event_data->name;
        $_POST['image'] = $event_data->image;
        $_POST['venue'] = $event_data->venue;
        $_POST['open_registrations'] = $event_data->open_registrations;
        $_POST['description'] = $event_data->description;
        $_POST['start_datetime'] = $event_data->start_datetime;
        $_POST['end_datetime'] = $event_data->end_datetime;

        $event_group_data = $event_group->find(
            ["club_event_groups.club_event_id" => $club_event_id],
            [
                "club_event_groups.id as group_id",
                "club_event_groups.name as group_name",
                "club_event_groups.club_id as club_id",
                "club_event_groups.club_event_id as club_event_id",
                "member.id as member_id",
                "member.user_id as user_id",
                "user.first_name as first_name",
                "user.last_name as last_name",
            ],
            [
                ["table" => "club_event_group_members", "as" => "member", "on" => "member.club_event_group_id = club_event_groups.id"],
                ["table" => "users", "as" => "user", "on" => "user.id = member.user_id"],
            ],
            [
                "type" => "group"
            ]
        );

        foreach ($event_group_data as $group_id => $group_data) {
        }
        show($event_group_data);
        $this->view($path, $data);
    }

    private function registrations($path, $data)
    {
        $this->view($path, $data);
    }

    private function sponsors($path, $data)
    {
        $data["sponsors_data"] = [];
        $data["packages_data"] = [];
        $storage = new Storage();
        $sponsor = new Sponsor();
        $package = new Package();

        $club_id = $storage->get('club_id');
        $club_event_id = $storage->get('club_event_id');

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $form_data = $_POST;
            if ($_POST['submit'] == "add-sponsor") {
                if (empty($club_id))  $_SESSION['alerts'] = [["status" => "error", "message" => "Club details are not found"]];
                else if (empty($club_event_id))  $_SESSION['alerts'] = [["status" => "error", "message" => "Event details are not found"]];
                else {
                    $form_data['club_id'] = $club_id;
                    $form_data['club_event_id'] = $club_event_id;
                    if ($sponsor->validateCreateSponsor($form_data)) {
                        try {
                            $sponsor->create($form_data);
                            $_SESSION['alerts'] = [["status" => "success", "message" => "Sponsor details added successfully"]];
                            redirect();
                        } catch (Throwable $th) {
                            var_dump($th);
                            $_SESSION['alerts'] = [["status" => "error", "message" => "Failed to add sponsor details"]];
                        }
                    } else {
                        $data['popups']["add-sponsor"] = true;
                    }

                    $data['errors'] = $sponsor->errors;
                }
            } else if ($_POST['submit'] == "edit-sponsor") {
                $where['id'] = $form_data['id'];

                if ($sponsor->validateEditSponsor($form_data)) {
                    try {
                        $sponsor->update($where, $form_data);

                        $_SESSION['alerts'] = [["status" => "success", "message" => "Sponsor details updated successfully"]];

                        redirect();
                    } catch (Throwable $th) {
                        $_SESSION['alerts'] = [["status" => "error", "message" => "Failed to update sponsor details"]];
                    }
                } else {
                    $data['popups']["edit-sponsor"] = $form_data;
                }

                $data['errors'] = $sponsor->errors;
            } else if ($_POST['submit'] == "delete-sponsor") {
                try {
                    $sponsor->delete(["id" => $form_data['id']]);

                    $_SESSION['alerts'] = [["status" => "success", "message" => "Sponsor deleted successfully"]];

                    redirect();
                } catch (Throwable $th) {
                    //var_dump($th);
                    $_SESSION['alerts'] = [["status" => "error", "message" => "Failed to delete Sponsor details"]];
                }

                $data['errors'] = $sponsor->errors;
            } else if ($_POST['submit'] == "add-package" || $_POST['submit'] == "edit-package" || $_POST['submit'] == "delete-package") {
                $this->packages($_POST);
            }

            redirect();
        }
        $data["packages_data"] = $package->find(["club_id" => $club_id, "club_event_id" => $club_event_id]);
        $data["sponsors_data"] = $sponsor->find(["club_id" => $club_id, "club_event_id" => $club_event_id]);
        $this->view($path, $data);
    }

    private function packages($data)
    {
        $storage = new Storage();
        $package = new Package();

        $club_id = $storage->get('club_id');
        $club_event_id = $storage->get('club_event_id');
        $club_member_id = $storage->get('club_member_id');
        $user_id = Auth::getId();

        $club_id = 1;
        $club_event_id = 1;
        $club_member_id = 1;

        if (empty($club_id))  $_SESSION['alerts'] = [["status" => "error", "message" => "Club details are not found"]];
        if (empty($club_event_id))  $_SESSION['alerts'] = [["status" => "error", "message" => "Event details are not found"]];

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
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
                            var_dump($th);
                            $_SESSION['alerts'] = [["status" => "error", "message" => "Failed to add package details"]];
                        }
                    } else {
                        $data['popups']["add-package"] = true;
                    }

                    $data['errors'] = $package->errors;
                }
            } else if ($_POST['submit'] == "edit-package") {
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
            } else if ($_POST['submit'] == "delete-package") {
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
                } else if ($_POST['submit'] == "add-expense") {
                    $budget_log_data["type"] = "EXPENSE";
                    $budget_log_data["description"] = "Added a new budget expense.";
                    $form_data['club_id'] = $club_id;
                    $form_data['club_event_id'] = $club_event_id;

                    if ($budget->validateAddExpense($form_data)) {
                        try {
                            $result = $budget->create($form_data);
                            if (!empty($result)) {
                                $budget_log_data["club_event_budget_id"] = $result->id;
                                $budget_log->create($budget_log_data);
                            }

                            $_SESSION['alerts'] = [["status" => "success", "message" => "Expense budget details added successfully"]];
                        } catch (Throwable $th) {
                            $_SESSION['alerts'] = [["status" => "error", "message" => "Failed to add budget details"]];
                        }
                    } else {
                        $data['popups']["add-expense"] = true;
                    }

                    $data['errors'] = $budget->errors;
                } else if ($_POST['submit'] == "edit-expense") {
                    $budget_log_data["type"] = "EXPENSE";
                    $budget_log_data["description"] = "Updated budget expense details.";
                    $budget_log_data["club_event_budget_id"] = $form_data['id'];
                    $where['id'] = $form_data['id'];

                    if ($budget->validateEditExpense($form_data)) {
                        try {
                            $budget->update($where, $form_data);
                            $budget_log->create($budget_log_data);

                            $_SESSION['alerts'] = [["status" => "success", "message" => "Expense budget details updated successfully"]];

                            redirect();
                        } catch (Throwable $th) {
                            $_SESSION['alerts'] = [["status" => "error", "message" => "Failed to update budget details"]];
                        }
                    } else {
                        $data['popups']["edit-expense"] = $form_data;
                    }

                    $data['errors'] = $budget->errors;
                } else if ($_POST['submit'] == "delete-expense") {
                    try {
                        $budget_log_data["type"] = "EXPENSE";
                        $budget_log_data["description"] = "Deleted budget expense details.";
                        $budget_log_data["club_event_budget_id"] = $form_data['id'];

                        /* delete the item */
                        // $budget_log->delete(["club_event_budget_id" => $form_data['id']]);
                        // $budget->delete(["id" => $form_data['id']]);

                        /* set the state as deleted */
                        $budget->update(["id" => $form_data['id']], ["is_deleted" => 1]);
                        $budget_log->create($budget_log_data);

                        $_SESSION['alerts'] = [["status" => "success", "message" => "Expense budget details deleted successfully"]];
                    } catch (Throwable $th) {
                        $_SESSION['alerts'] = [["status" => "error", "message" => "Failed to delete budget details"]];
                    }

                    $data['errors'] = $budget->errors;
                }
            }

            $data["table_data"] = $budget->find(["club_id" => $club_id, "club_event_id" => $club_event_id, "is_deleted" => 0, "type" => upperCase($data['tab'])]);
            /* fetch results */
            $db->commit();

            if ($_SERVER['REQUEST_METHOD'] == "POST") redirect();
        } catch (\Throwable $th) {
            $data['errors'] = "Failed to process the action, please try again later.";
            $db->rollback();
        }


        $this->view($path, $data);
    }

    private function agenda($path, $data)
    {
        $this->view($path, $data);
    }

    private function announcements($path, $data)
    {
        $this->view($path, $data);
    }

    private function complains($path, $data)
    {
        $this->view($path, $data);
    }
}
