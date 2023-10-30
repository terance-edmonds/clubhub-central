<?php

class Home extends Controller
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

        /* authenticate */
        Auth::authenticate();

        $this->view("home", $data);
    }
}
