<?php

class Profile extends Controller
{
    public function index()
    {
        $data = [
            "tab" => "gallery"
        ];
        $params = $_GET;

        if (isset($params["tab"])) $data["tab"] = $params["tab"];

        $this->view("profile", $data);
    }
}
