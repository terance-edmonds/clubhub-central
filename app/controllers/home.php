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

        $this->view("home", $data);
    }
}
