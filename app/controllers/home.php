<?php

class Home extends Controller
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

        $left_bar = [
            "calendar_data" => [
                "current_path" => "/"
            ]
        ];

        $right_bar = [
            "events" => $today_events
        ];

        $data = [
            "left_bar" => $left_bar,
            "right_bar" => $right_bar,
        ];

        /* authenticate */
        Auth::authenticate();

        $this->view("home", $data);
    }
}
