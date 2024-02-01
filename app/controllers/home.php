<?php

class Home extends Controller
{
    public function index()
    {
        $event = new Event();
        $post = new ClubPost();
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

        $menu_side_bar = array_merge($left_bar);

        /* fetch posts */
        $posts_data = $post->find(
            ["club_posts.is_deleted" => 0],
            [
                "club_posts.id",
                "club_posts.post_name",
                "club_posts.description",
                "club_posts.image",
                "club_posts.created_datetime",
                "user.first_name",
                "user.last_name",
                "club.id as club_id",
                "club.name as club_name",
                "club.image as club_image",
            ],
            [
                ["table" => "users", "as" => "user", "on" => "club_posts.user_id = user.id"],
                ["table" => "clubs", "as" => "club", "on" => "club_posts.club_id = club.id"]
            ],
        );

        $data = [
            "left_bar" => $left_bar,
            "right_bar" => $right_bar,
            "menu_side_bar" => $menu_side_bar,
            "posts" => $posts_data
        ];

        /* authenticate */
        Auth::authenticate();

        $this->view("home", $data);
    }
}
