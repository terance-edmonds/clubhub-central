<?php

class Routes
{
    protected static $routes = [
        "main" => [
            "MEMBER",
            "TREASURER",
            "SECRETORY",
            "PRESIDENT",
            "CLUB_IN_CHARGE",
            "SUPER_ADMIN",
            "ADMIN",
            "USER"
        ],
        "login" => [
            "ANY"
        ],
        "register" => [
            "ANY"
        ],
        "register/verify" => [
            "ANY"
        ],
        "not-found" => [
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
        "calendar" => [
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
        "profile/edit" => [
            "MEMBER",
            "TREASURER",
            "SECRETORY",
            "PRESIDENT",
            "CLUB_IN_CHARGE",
            "SUPER_ADMIN",
            "ADMIN",
            "USER"
        ],
        /* event routes */
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
        "events/event" => [
            "ANY"
        ],
        /* event dashboard routes */
        "events/dashboard" => [
            "MEMBER",
            "TREASURER",
            "SECRETORY",
            "PRESIDENT",
            "CLUB_IN_CHARGE",
        ],
        "events/dashboard/registrations" => [
            "MEMBER",
            "TREASURER",
            "SECRETORY",
            "PRESIDENT",
            "CLUB_IN_CHARGE",
        ],
        "events/dashboard/registrations/add" => [
            "MEMBER",
            "TREASURER",
            "SECRETORY",
            "PRESIDENT",
            "CLUB_IN_CHARGE",
        ],
        "events/dashboard/registrations/attendance" => [
            "MEMBER",
            "TREASURER",
            "SECRETORY",
            "PRESIDENT",
            "CLUB_IN_CHARGE",
        ],
        "events/dashboard/sponsors" => [
            "MEMBER",
            "TREASURER",
            "SECRETORY",
            "PRESIDENT",
            "CLUB_IN_CHARGE",
        ],
        "events/dashboard/budgets" => [
            "MEMBER",
            "TREASURER",
            "SECRETORY",
            "PRESIDENT",
            "CLUB_IN_CHARGE",
        ],
        "events/dashboard/agenda" => [
            "MEMBER",
            "TREASURER",
            "SECRETORY",
            "PRESIDENT",
            "CLUB_IN_CHARGE",
        ],
        "events/dashboard/announcements" => [
            "MEMBER",
            "TREASURER",
            "SECRETORY",
            "PRESIDENT",
            "CLUB_IN_CHARGE",
        ],
        "events/dashboard/complains" => [
            "MEMBER",
            "TREASURER",
            "SECRETORY",
            "PRESIDENT",
            "CLUB_IN_CHARGE",
        ],
        /* club routes */
        "club" => [
            "MEMBER",
            "TREASURER",
            "SECRETORY",
            "PRESIDENT",
            "CLUB_IN_CHARGE",
            "SUPER_ADMIN",
            "ADMIN",
        ],
        /* club dashboard routes */
        "club/dashboard" => [
            "MEMBER",
            "TREASURER",
            "SECRETORY",
            "PRESIDENT",
            "CLUB_IN_CHARGE",
            "SUPER_ADMIN",
            "ADMIN",
        ],
        "club/dashboard/events/add" => [
            "PRESIDENT",
            "CLUB_IN_CHARGE",
        ],
        "club/dashboard/members" => [
            "SECRETORY",
            "PRESIDENT",
            "CLUB_IN_CHARGE",
        ],
        "club/dashboard/meetings" => [
            "SECRETORY",
            "PRESIDENT",
            "CLUB_IN_CHARGE",
        ],
        "club/dashboard/reports" => [
            "SECRETORY",
            "SECRETORY",
            "PRESIDENT",
            "CLUB_IN_CHARGE",
        ],
        "club/dashboard/community" => [
            "MEMBER",
            "TREASURER",
            "SECRETORY",
            "PRESIDENT",
            "CLUB_IN_CHARGE",
        ],
        "club/dashboard/requests" => [
            "CLUB_IN_CHARGE",
        ],
        "club/dashboard/requests/add" => [
            "CLUB_IN_CHARGE",
        ],
        "club/dashboard/posts" => [
            "MEMBER",
            "TREASURER",
            "SECRETORY",
            "PRESIDENT",
            "CLUB_IN_CHARGE",
        ],
        "club/dashboard/posts/add" => [
            "MEMBER",
            "TREASURER",
            "SECRETORY",
            "PRESIDENT",
            "CLUB_IN_CHARGE",
        ],
        "club/dashboard/logs" => [
            "TREASURER",
            "SECRETORY",
            "PRESIDENT",
            "CLUB_IN_CHARGE",
        ],
        "club/dashboard/election" => [
            "MEMBER",
            "TREASURER",
            "SECRETORY",
            "PRESIDENT",
            "CLUB_IN_CHARGE",
        ],
        "club/dashboard/election/add" => [
            "PRESIDENT",
            "CLUB_IN_CHARGE",
        ],
        /* super admin routes */
        "admin/dashboard" => [
            "SUPER_ADMIN"
        ],
        "admin/dashboard/events" => [
            "SUPER_ADMIN"
        ],
        "admin/dashboard/requests" => [
            "SUPER_ADMIN"
        ],
        "admin/dashboard/users" => [
            "SUPER_ADMIN"
        ],
    ];
}
