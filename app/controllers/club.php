<?php

class Club extends Controller
{
    public function index()
    {
        $data = [
            "tab" => "club-posts",
            "club_id" => ""
        ];
        $params = $_GET;

        if (isset($params["id"])) $data["club_id"] = $params["id"];
        if (isset($params["tab"])) $data["tab"] = $params["tab"];

        $this->view("club", $data);
    }
}
