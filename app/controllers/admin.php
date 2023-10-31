<?php

use function _\upperCase;

class Admin extends Controller{
        public function index(){

            $this->view("admin");
        }

        public function dashboard(){
            $path = $_GET["url"];
        $func = "view";

        /* use outlined icons */
        $menu = [
            ["id" => "clubs", "name" => "Club", "icon" => "info", "path" => "/dashboard", "active" => "false"],
            ["id" => "events", "name" => "Events", "icon" => "app_registration", "path" => "/dashboard/events", "active" => "false"],
            ["id" => "requests", "name" => "Requests", "icon" => "diversity_3", "path" => "/dashboard/requests", "active" => "false"],
            ["id" => "users", "name" => "Users", "icon" => "monetization_on", "path" => "/dashboard/users", "active" => "false"],
            

        ];

            $data = [
            "menu" => $menu
            ];

            $this->$func($path, $data);
        }


}