<?php

use function _\upperCase;

class Events extends Controller
{
    public function index()
    {
        $event = new Event();
        $moment = new \Moment\Moment();

        $today_events = $event->find(
            [
                "start_datetime" => [
                    "data" => $moment->format('Y-m-d') . "%",
                    "operator" => "like"
                ],
                "club_events.state" => "ACTIVE"
            ],
            [
                "club_events.id as id",
                "club_events.name as name",
                "club_events.venue as venue",
                "club_events.image as image",
                "club_events.start_datetime as start_datetime",
                "club_events.end_datetime as end_datetime",
                "club_events.state as state",
                "club.id as club_id",
                "club.name as club_name"
            ],
            [
                ["table" => "clubs", "as" => "club", "on" => "club_events.club_id = club.id"]
            ]
        );
        $events = $event->find(
            [
                "club_events.state" => "ACTIVE"
            ],
            [
                "club_events.id as id",
                "club_events.name as name",
                "club_events.venue as venue",
                "club_events.image as image",
                "club_events.description as description",
                "club_events.start_datetime as start_datetime",
                "club_events.end_datetime as end_datetime",
                "club_events.state as state",
                "club.id as club_id",
                "club.name as club_name",
                "club.image as club_image",
            ],
            [
                ["table" => "clubs", "as" => "club", "on" => "club_events.club_id = club.id"]
            ]
        );

        $left_bar = [
            "calendar_data" => [
                "current_path" => "/"
            ]
        ];

        $right_bar = [
            "events" => $today_events
        ];

        $menu_side_bar = array_merge($left_bar);

        $data = [
            "left_bar" => $left_bar,
            "right_bar" => $right_bar,
            "events" => $events,
            "menu_side_bar" => $menu_side_bar
        ];

        $this->view("events", $data);
    }

    public function scroll()
    {
        $event = new Event();
        $page = 1;
        $limit = 10;

        if (!empty($_GET['page']) && is_numeric($_GET['page']))
            $page = $_GET['page'];

        $events = $event->find(
            [
                "club_events.state" => "ACTIVE"
            ],
            [
                "club_events.id as id",
                "club_events.name as name",
                "club_events.venue as venue",
                "club_events.image as image",
                "club_events.description as description",
                "club_events.start_datetime as start_datetime",
                "club_events.end_datetime as end_datetime",
                "club_events.state as state",
                "club.id as club_id",
                "club.name as club_name",
                "club.image as club_image",
            ],
            [
                ["table" => "clubs", "as" => "club", "on" => "club_events.club_id = club.id"]
            ],
            [
                "limit" => $limit,
                "offset" => ($page - 1) * $limit
            ]
        );

        $data['events'] = $events;

        $this->view("events/scroll", $data);
    }

    public function event()
    {
        $event_id = $_GET["id"];
        $moment = new \Moment\Moment();
        $event = new Event();
        $event_registration = new EventRegistration();

        /* if event ID is not found */
        if (empty($event_id)) {
            return redirect('not-found');
        }

        /* if event details are not found */
        $event_details = $event->one(["id" => $event_id]);
        if (empty($event_details) || $event_details->state != 'ACTIVE') {
            return redirect('not-found');
        }

        /* if event is not public */
        if (!Auth::logged() && !$event_details->is_public) {
            return redirect('login');
        }

        /* right side bar data */
        $today_event_options = [
            "start_datetime" => [
                "data" => $moment->format('Y-m-d') . "%",
                "operator" => "like"
            ],
            "club_events.state" => "ACTIVE"
        ];

        if ($event_details->is_public) $today_event_options['is_public'] = $event_details->is_public;
        $today_events = $event->find(
            $today_event_options,
            [
                "club_events.id as id",
                "club_events.name as name",
                "club_events.venue as venue",
                "club_events.image as image",
                "club_events.start_datetime as start_datetime",
                "club_events.end_datetime as end_datetime",
                "club_events.state as state",
                "club.id as club_id",
                "club.name as club_name"
            ],
            [
                ["table" => "clubs", "as" => "club", "on" => "club_events.club_id = club.id"]
            ]
        );

        $right_bar = [
            "events" => $today_events
        ];

        $data = [
            "popups" => [],
            "errors" => [],
            "right_bar" => $right_bar,
            "event_data" => [
                "name" => $event_details->name,
                "description" => $event_details->description,
                "is_public" => $event_details->is_public,
                "open_registrations" => $event_details->open_registrations,
                "image" => $event_details->image,
                "start_date" => $moment->format('dS F'),
                "start_time" => $moment->format('h:i A'),
                "venue" => $event_details->venue,
            ]
        ];

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $form_data = $_POST;

            /* if no status then start a new session */
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            if ($_POST['submit'] == 'event-registration') {
                if ($event_registration->validateAddEventRegistration($form_data)) {
                    try {
                        $event_data = $event->one(["id" => $event_details->id]);

                        $result = $event_registration->create([
                            "club_id" => $event_details->club_id,
                            "club_event_id" => $event_details->id,
                            "user_name" => $form_data['user_name'],
                            "user_email" => $form_data['user_email'],
                            "user_contact" => $form_data['user_contact'],
                        ]);

                        /* send attendance mail */
                        $this->sendAttendanceMail([
                            "user_name" => $form_data['user_name'],
                            "user_email" => $form_data['user_email'],
                            "event_name" => $event_data->name,
                            "id" => $result->id
                        ]);

                        $_SESSION['alerts'] = [["status" => "success", "message" => "Registered to the event successfully"]];
                    } catch (\Throwable $th) {
                        $_SESSION['alerts'] = [["status" => "error", "message" => "Event registration failed, please try again later"]];
                    }

                    return redirect();
                } else {
                    $data['popups']['event-register'] = true;
                }
            }

            $data['errors'] = $event_registration->errors;
        }

        $this->view("events/event", $data);
    }

    public function dashboard()
    {
        $path = $_GET["url"];
        $func = "view";

        $storage = new Storage();
        $club_id = $storage->get('club_id');
        $club_role = $storage->get('club_role');
        $club_event_id = $storage->get('club_event_id');

        if (empty($club_id) || empty($club_event_id)) {
            return redirect('not-found');
        }

        /* use outlined icons */
        $menu = [
            ["id" => "events", "name" => "Event Details", "icon" => "info", "path" => "/events/dashboard", "active" => "false"],
            ["id" => "registrations", "name" => "registrations", "icon" => "app_registration", "path" => ["/events/dashboard/registrations", "/events/dashboard/registrations/attendance"], "active" => "false"],
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
        $db = new Database();
        $club_member = new ClubMember();
        $event = new Event($db);
        $event_group = new EventGroup($db);
        $event_group_member = new EventGroupMember($db);

        $storage = new Storage();
        $club_id = $storage->get('club_id');
        $club_event_id = $storage->get('club_event_id');

        $event_data = $event->one(["id" => $club_event_id, "club_id" => $club_id]);

        $data['start_datetime'] = $event_data->start_datetime;
        $data['club_members_data'] = $club_member->find(
            ["club_id" => $club_id, "state" => "ACCEPTED"],
            [
                "club_members.id as id",
                "user_id",
                "club_id",
                "user.first_name as first_name",
                "user.last_name as last_name",
            ],
            [
                ["table" => "users", "as" => "user", "on" => "club_members.user_id = user.id"]
            ]
        );

        $image_uploaded = true;

        try {
            $db->transaction();

            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                $form_data = $_POST;

                if ($form_data['submit'] == 'update_event') {
                    $group_errors = [];

                    if (!empty($_FILES['image']['name'])) {
                        $file_upload = uploadFile('image');

                        if (empty($file_upload)) {
                            $image_uploaded = false;
                            $data["errors"]["image"] = "Failed to upload the image, please try again later";
                        } else {
                            $form_data['image'] = $file_upload['url'];
                        }
                    } else if (!empty($form_data['pre_uploaded_image'])) {
                        $form_data['image'] = $form_data['pre_uploaded_image'];
                    }

                    if ($image_uploaded && $event->validateUpdateEvent($form_data)) {
                        try {
                            /* remove current records */
                            $event_group_member->delete(["club_event_id" => $club_event_id]);
                            $event_group->delete(["club_event_id" => $club_event_id]);

                            $event->update([
                                "id" => $club_event_id
                            ], [
                                "name" => $form_data['name'],
                                "image" => $form_data['image'],
                                "venue" => $form_data['venue'],
                                "open_registrations" => empty($form_data['open_registrations']) ? 0 : 1,
                                "is_public" => empty($form_data['is_public']) ? 0 : 1,
                                "start_datetime" => $form_data['start_datetime'],
                                "end_datetime" => $form_data['end_datetime'],
                                "description" => $form_data['description']
                            ]);
                        } catch (\Throwable $th) {
                            throw new Error("Failed to update event details");
                        }

                        foreach ($form_data['groups'] as $key => $group) {
                            $permissions = $group['permissions'];

                            if ($event_group->validateCreateEventGroup($group)) {
                                try {
                                    $event_group_result = $event_group->create([
                                        "name" => $group['name'],
                                        "club_id" => $club_id,
                                        "club_event_id" =>  $club_event_id,
                                        "budget_permission" => empty($permissions['budget_permission']) ? 0 : 1,
                                        "details_permission" => empty($permissions['details_permission']) ? 0 : 1,
                                        "registration_permission" => empty($permissions['registration_permission']) ? 0 :  1,
                                        "sponsor_permission" => empty($permissions['sponsor_permission']) ? 0 : 1,
                                    ]);
                                } catch (\Throwable $th) {
                                    throw new Error("Failed to create an event " . $group['name'] . " group");
                                }

                                foreach ($group['members'] as $member) {
                                    try {
                                        $event_group_member->create([
                                            "club_id" => $club_id,
                                            "club_event_id" => $club_event_id,
                                            "club_event_group_id" => $event_group_result->id,
                                            "user_id" => $member['user_id'],
                                            "club_member_id" => $member['id'],
                                        ]);
                                    } catch (\Throwable $th) {
                                        throw new Error("Failed to add member to event " . $group['name'] . " group");
                                    }
                                }
                            }

                            if (count($event_group->errors) > 0) {
                                $group_errors[$key] = $event_group->errors;
                            }
                        }

                        $_SESSION['alerts'] = [["status" => "success", "message" => "Updated event details successfully"]];
                    }

                    $data['errors'] = $event->errors;
                    if (count($group_errors) > 0) {
                        $data['errors']['groups'] = $group_errors;
                    }
                }
            } else {
                /* set event details */
                $_POST['name'] = $event_data->name;
                $_POST['image'] = $event_data->image;
                $_POST['venue'] = $event_data->venue;
                $_POST['open_registrations'] = $event_data->open_registrations;
                $_POST['is_public'] = $event_data->is_public;
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
                        "club_event_groups.budget_permission as budget_permission",
                        "club_event_groups.details_permission as details_permission",
                        "club_event_groups.sponsor_permission as sponsor_permission",
                        "club_event_groups.registration_permission as registration_permission",
                        "member.club_member_id as member_id",
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
                    $_POST['groups'][$group_id] = [
                        "id" => $group_id,
                        "name" => $group_data[0]['group_name'],
                        "permissions" => [
                            "budget_permission" => $group_data[0]['budget_permission'],
                            "details_permission" => $group_data[0]['details_permission'],
                            "registration_permission" => $group_data[0]['registration_permission'],
                            "sponsor_permission" => $group_data[0]['sponsor_permission'],
                        ],
                        "members" => []
                    ];

                    foreach ($group_data as $group_member) {
                        array_push($_POST['groups'][$group_id]['members'], [
                            "user_id" => $group_member['user_id'],
                            "id" => $group_member['member_id'],
                            "name" => $group_member['first_name'] . " " . $group_member['last_name'],
                        ]);
                    }
                }
            }

            $db->commit();

            if ($_SERVER['REQUEST_METHOD'] == "POST" &&  count($data['errors']) == 0) return redirect();
        } catch (\Throwable $th) {
            $db->rollback();
            $_SESSION['alerts'] = [["status" => "error", "message" => $th->getMessage() || "Failed to process the action, please try again later."]];
        }

        $this->view($path, $data);
    }

    private function registrations($path, $data)
    {
        $event = new Event();
        $event_registration = new EventRegistration();
        $storage = new Storage();
        $club_id = $storage->get('club_id');
        $club_event_id = $storage->get('club_event_id');

        $data['user_found'] = False;
        $data['total_count'] = 0;
        $data['limit'] = 10;
        $data['page'] = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $form_data = $_POST;

            if (!empty($_POST['form']) && $_POST['form'] == 'open-registrations-update') {
                try {
                    $event->update(
                        [
                            "id" => $club_event_id
                        ],
                        [
                            "open_registrations" =>  empty($form_data['open_registrations']) ? 0 : 1,
                        ]
                    );

                    $_SESSION['alerts'] = [["status" => "success", "message" => "Event registration state updated successfully"]];
                } catch (\Throwable $th) {
                    $_SESSION['alerts'] = [["status" => "error", "message" => "Event registration state update failed, please try again later"]];
                }

                return redirect();
            } else if ($_POST['submit'] == 'event-registration') {
                if ($event_registration->validateAddEventRegistration($form_data)) {
                    try {
                        $event_data = $event->one(["id" => $club_event_id]);

                        $result = $event_registration->create([
                            "club_id" => $club_id,
                            "club_event_id" => $club_event_id,
                            "user_name" => $form_data['user_name'],
                            "user_email" => $form_data['user_email'],
                            "user_contact" => $form_data['user_contact'],
                        ]);

                        /* send attendance mail */
                        $this->sendAttendanceMail([
                            "user_name" => $form_data['user_name'],
                            "user_email" => $form_data['user_email'],
                            "event_name" => $event_data->name,
                            "id" => $result->id
                        ]);

                        $_SESSION['alerts'] = [["status" => "success", "message" => "Registered to the event successfully"]];
                    } catch (\Throwable $th) {
                        $_SESSION['alerts'] = [["status" => "error", "message" => "Event registration failed, please try again later"]];
                    }

                    return redirect();
                } else {
                    $data['popups']['event-register'] = true;
                }
            } else if ($_POST['submit'] == 'event-registration-update') {
                if ($event_registration->validateUpdateEventRegistration($form_data)) {
                    try {
                        $event_registration->update(["id" => $form_data['id']], [
                            "user_name" => $form_data['user_name'],
                            "user_email" => $form_data['user_email'],
                            "user_contact" => $form_data['user_contact'],
                            "attended" => empty($form_data['attended']) ? 0 : 1,
                        ]);

                        $_SESSION['alerts'] = [["status" => "success", "message" => "Registration details updated successfully"]];
                    } catch (\Throwable $th) {
                        $_SESSION['alerts'] = [["status" => "error", "message" => "Registration details update failed, please try again later"]];
                    }

                    return redirect();
                } else {
                    $data['popups']['update-event-register'] = true;
                }
            } else if ($_POST['submit'] == 'event-attendance-search') {
                $result = $event_registration->one(["id" => $form_data['id']]);

                if (empty($result)) {
                    $_SESSION['alerts'] = [["status" => "error", "message" => "User registration details not found"]];
                } else {
                    $_POST['id'] = $result->id;
                    $_POST['user_name'] = $result->user_name;
                    $_POST['user_email'] = $result->user_email;
                    $_POST['user_contact'] = $result->user_contact;

                    $data['user_found'] = True;
                }
            } else if ($_POST['submit'] == 'event-attendance-mark') {
                try {
                    $event_registration->update(["id" => $form_data['id']], [
                        "attended" => 1,
                    ]);

                    $_SESSION['alerts'] = [["status" => "success", "message" => "Event attendance marked as attended"]];
                } catch (\Throwable $th) {
                    $_SESSION['alerts'] = [["status" => "error", "message" => "Attendance details update failed, please try again later"]];
                }

                return redirect();
            } else if ($_POST['submit'] == "delete-event-register") {
                try {
                    $event_registration->delete(["id" => $form_data['id']]);

                    $_SESSION['alerts'] = [["status" => "success", "message" => "Event registration details deleted successfully"]];
                } catch (Throwable $th) {
                    $_SESSION['alerts'] = [["status" => "error", "message" => "Failed to delete registration details"]];
                }

                return redirect();
            } else if ($_POST['submit'] == 'send-attendance-mail') {
                try {
                    $event_registration_data = $event_registration->one(["id" => $form_data['id']]);
                    $event_data = $event->one(["id" => $club_event_id]);

                    /* send attendance mail */
                    $this->sendAttendanceMail([
                        "user_name" => $event_registration_data->user_name,
                        "user_email" => $event_registration_data->user_email,
                        "event_name" => $event_data->name,
                        "id" => $form_data['id']
                    ]);

                    $_SESSION['alerts'] = [["status" => "success", "message" => "Event attendance mail sent successfully"]];
                } catch (\Throwable $th) {
                    $_SESSION['alerts'] = [["status" => "error", "message" => "Failed to send attendance mail"]];
                }

                return redirect();
            }

            $data['errors'] = $event_registration->errors;
        }

        /* fetch event registration data */
        /* count */
        $total_count = $event_registration->find([
            "club_id" => $club_id,
            "club_event_id" => $club_event_id,
        ], ["count(*) as count"], [], [], isset($_GET['search']) ? $_GET['search'] : '');
        if (!empty($total_count[0]->count)) $data['total_count'] = $total_count[0]->count;

        /* data */
        $data['event_registrations_data'] = $event_registration->find([
            "club_id" => $club_id,
            "club_event_id" => $club_event_id,
        ], [], [], [
            "limit" => $data['limit'],
            "offset" => ($data['page'] - 1) * $data['limit'],
        ], isset($_GET['search']) ? $_GET['search'] : '');

        /* fetch event details */
        $event_data = $event->one(["id" => $club_event_id]);
        $_POST['open_registrations'] = $event_data->open_registrations;

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

        $data['total_packages_count'] = 0;
        $data['packages_limit'] = 10;
        $data['packages_page'] = isset($_GET['package_page']) && is_numeric($_GET['package_page']) ? $_GET['package_page'] : 1;

        $data['total_sponsors_count'] = 0;
        $data['sponsors_limit'] = 10;
        $data['sponsors_page'] = isset($_GET['sponsor_page']) && is_numeric($_GET['sponsor_page']) ? $_GET['sponsor_page'] : 1;

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
                } catch (Throwable $th) {
                    //var_dump($th);
                    $_SESSION['alerts'] = [["status" => "error", "message" => "Failed to delete Sponsor details"]];
                }

                $data['errors'] = $sponsor->errors;
            } else if ($_POST['submit'] == "add-package" || $_POST['submit'] == "edit-package" || $_POST['submit'] == "delete-package") {
                $this->packages($_POST);
            }

            if (count($data['errors']) == 0) return redirect();
        }

        /* fetch package data */
        /* pagination */
        $packages_total_count = $package->find([
            "club_id" => $club_id,
            "club_event_id" => $club_event_id
        ], ["count(*) as count"], [], [], isset($_GET['packages_search']) ? $_GET['packages_search'] : '');
        if (!empty($packages_total_count[0]->count)) $data['total_packages_count'] = $packages_total_count[0]->count;
        /* data */
        $data["packages_data"] = $package->find(["club_id" => $club_id, "club_event_id" => $club_event_id], [], [], [], isset($_GET['packages_search']) ? $_GET['packages_search'] : '');

        /* fetch sponsors data */
        /* pagination */
        $sponsors_total_count = $sponsor->find([
            "club_id" => $club_id,
            "club_event_id" => $club_event_id
        ], ["count(*) as count"], [], [], isset($_GET['sponsors_search']) ? $_GET['sponsors_search'] : '');
        if (!empty($sponsors_total_count[0]->count)) $data['total_sponsors_count'] = $sponsors_total_count[0]->count;
        /* data */
        $data["sponsors_data"] = $sponsor->find(["club_id" => $club_id, "club_event_id" => $club_event_id], [], [], [], isset($_GET['sponsors_search']) ? $_GET['sponsors_search'] : '');

        $this->view($path, $data);
    }

    private function packages($data)
    {
        $storage = new Storage();
        $package = new Package();

        $club_id = $storage->get('club_id');
        $club_event_id = $storage->get('club_event_id');

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
                        } catch (Throwable $th) {
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
                } catch (Throwable $th) {
                    var_dump($th);
                    $_SESSION['alerts'] = [["status" => "error", "message" => "Failed to delete package details"]];
                }

                $data['errors'] = $package->errors;
            }

            if (count($data['errors']) == 0) return redirect();
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

        $data['total_count'] = 0;
        $data['limit'] = 10;
        $data['page'] = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

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

            /* fetch budget data */
            /* pagination */
            $total_count = $budget->find([
                "club_id" => $club_id,
                "club_event_id" => $club_event_id,
                "is_deleted" => 0,
                "type" => upperCase($data['tab'])
            ], ["count(*) as count"], [], [], isset($_GET['search']) ? $_GET['search'] : '');
            if (!empty($total_count[0]->count)) $data['total_count'] = $total_count[0]->count;

            /* data */
            $data["table_data"] = $budget->find(["club_id" => $club_id, "club_event_id" => $club_event_id, "is_deleted" => 0, "type" => upperCase($data['tab'])], [], [], [], isset($_GET['search']) ? $_GET['search'] : '');

            /* calculate the income/expenses/profile/loss */
            $data['income_data'] = 0;
            $data['expense_data'] = 0;
            $income_data = $budget->find(["club_id" => $club_id, "club_event_id" => $club_event_id, "is_deleted" => 0, "type" => "INCOME"], ["sum(amount) as total"]);
            $expense_data = $budget->find(["club_id" => $club_id, "club_event_id" => $club_event_id, "is_deleted" => 0, "type" => "EXPENSE"], ["sum(amount) as total"]);

            if ($income_data[0]->total) $data['income_data'] = $income_data[0]->total;
            if ($expense_data[0]->total) $data['expense_data'] = $expense_data[0]->total;
            $data['net_value'] = $data['income_data'] - $data['expense_data'];

            /* fetch results */
            $db->commit();

            if ($_SERVER['REQUEST_METHOD'] == "POST" && count($data['errors']) == 0) return redirect();
        } catch (\Throwable $th) {
            $_SESSION['alerts'] = [["status" => "error", "message" => "Failed to process the action, please try again later"]];
            $db->rollback();
        }


        $this->view($path, $data);
    }

    private function agenda($path, $data)
    {
        $storage = new Storage();
        $agenda = new Agenda();

        $club_id = $storage->get('club_id');
        $club_event_id = $storage->get('club_event_id');

        $data['total_count'] = 0;
        $data['limit'] = 10;
        $data['page'] = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $form_data = $_POST;

            if ($_POST['submit'] == 'create-event-agenda') {
                if ($agenda->validateAddEventAgenda($form_data)) {
                    try {
                        $agenda->create([
                            "club_id" => $club_id,
                            "club_event_id" => $club_event_id,
                            "name" => $form_data['name'],
                            "venue" => $form_data['venue'],
                            "note" => $form_data['note'],
                            "datetime" => $form_data['datetime'],
                        ]);

                        $_SESSION['alerts'] = [["status" => "success", "message" => "Agenda details added successfully"]];
                    } catch (\Throwable $th) {
                        $_SESSION['alerts'] = [["status" => "error", "message" => "Failed to add agenda details"]];
                    }

                    return redirect();
                } else {
                    $data['popups']["add-agenda"] = true;
                }
            } else if ($_POST['submit'] == 'update-event-agenda') {
                if ($agenda->validateAddEventAgenda($form_data)) {
                    try {
                        $agenda->update(["id" => $form_data['id']], [
                            "name" => $form_data['name'],
                            "venue" => $form_data['venue'],
                            "note" => $form_data['note'],
                            "datetime" => $form_data['datetime'],
                        ]);

                        $_SESSION['alerts'] = [["status" => "success", "message" => "Agenda details updated successfully"]];
                    } catch (\Throwable $th) {
                        $_SESSION['alerts'] = [["status" => "error", "message" => "Failed to update agenda details"]];
                    }

                    return redirect();
                } else {
                    $data['popups']["edit-agenda"] = true;
                }
            } else if ($_POST['submit'] == "delete-agenda") {
                try {
                    $agenda->delete(["id" => $form_data['id']]);

                    $_SESSION['alerts'] = [["status" => "success", "message" => "Agenda details deleted successfully"]];
                } catch (Throwable $th) {
                    $_SESSION['alerts'] = [["status" => "error", "message" => "Failed to delete agenda details"]];
                }

                return redirect();
            }

            $data['errors'] = $agenda->errors;
        }

        /* fetch data */
        /* pagination */
        $total_count = $agenda->find([
            "club_id" => $club_id,
            "club_event_id" => $club_event_id
        ], ["count(*) as count"], [], [], isset($_GET['search']) ? $_GET['search'] : '');
        if (!empty($total_count[0]->count)) $data['total_count'] = $total_count[0]->count;

        /* data */
        $data['agenda_data'] = $agenda->find(["club_id" => $club_id, "club_event_id" => $club_event_id], [], [], [], isset($_GET['search']) ? $_GET['search'] : '');

        $this->view($path, $data);
    }

    private function announcements($path, $data)
    {
        $this->view($path, $data);
    }

    private function complains($path, $data)
    {
        $complain = new Complain();
        $storage = new Storage();

        $club_id = $storage->get('club_id');
        $club_event_id = $storage->get('club_event_id');

        $data['total_count'] = 0;
        $data['limit'] = 10;
        $data['page'] = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $form_data = $_POST;

            if ($_POST['submit'] == "delete-complain") {
                try {
                    $complain->delete(["id" => $form_data['id']]);

                    $_SESSION['alerts'] = [["status" => "success", "message" => "Complain details deleted successfully"]];
                } catch (Throwable $th) {
                    $_SESSION['alerts'] = [["status" => "error", "message" => "Failed to delete complain details"]];
                }

                return redirect();
            }
        }

        /* fetch data */
        $data['complains_data'] = $complain->find(["club_id" => $club_id, "club_event_id" => $club_event_id]);

        $this->view($path, $data);
    }

    private function sendAttendanceMail($data)
    {
        $mail = new Mail();
        $qr_code_image = generateQRCode($data['id']);

        $mail->send([
            "to" => [
                "mail" => $data['user_email'],
                "name" => $data['user_name']
            ],
            "subject" => "Attendance Tracking",
            "body" => $mail->template("event-attendance", [
                "from_email" => MAIL_USER,
                "from_name" => MAIL_USERNAME,
                "event_name" => $data['event_name'],
                "qr_code_image" => $qr_code_image
            ])
        ]);
    }
}
