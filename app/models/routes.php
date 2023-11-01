<?php

class Routes
{
    protected static $routes = [
        "main" => [
            "ANY"
        ],
        "home" => [
            "MEMBER",
            "TREASURER",
            "SECRETORY",
            "PRESIDENT",
            "CLUB_IN_CHARGE",
            "SUPER_ADMIN",
            "ADMIN",
            "USER"
        ],
        "profile" => [
            "MEMBER",
            "TREASURER",
            "SECRETORY",
            "PRESIDENT",
            "CLUB_IN_CHARGE",
            "SUPER_ADMIN",
            "ADMIN",
            "USER"
        ],
        "events" => [
            "MEMBER",
            "TREASURER",
            "SECRETORY",
            "PRESIDENT",
            "CLUB_IN_CHARGE",
            "SUPER_ADMIN",
            "ADMIN",
            "USER"
        ],
        "events/dashboard" => [
            "MEMBER",
            "TREASURER",
            "SECRETORY",
            "PRESIDENT",
            "CLUB_IN_CHARGE",
            "SUPER_ADMIN",
            "ADMIN",
        ],
        "club" => [
            "MEMBER",
            "TREASURER",
            "SECRETORY",
            "PRESIDENT",
            "CLUB_IN_CHARGE",
            "SUPER_ADMIN",
            "ADMIN",
        ],
        "club/dashboard" => [
            "MEMBER",
            "TREASURER",
            "SECRETORY",
            "PRESIDENT",
            "CLUB_IN_CHARGE",
            "SUPER_ADMIN",
            "ADMIN",
        ]
    ];
}
