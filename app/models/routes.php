<?php

class Routes
{
    protected static $routes = [
        "main" => [
            "MEMBER",
            "TREASURER",
            "SECRETARY",
            "PRESIDENT",
            "CLUB_IN_CHARGE",
            "SUPER_ADMIN",
            "ADMIN",
            "USER"
        ],
        "login" => [
            "ANY"
        ],
        "password" => [
            "ANY"
        ],
        "password/reset" => [
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
            "SECRETARY",
            "PRESIDENT",
            "CLUB_IN_CHARGE",
            "SUPER_ADMIN",
            "ADMIN",
            "USER"
        ],
        "calendar" => [
            "MEMBER",
            "TREASURER",
            "SECRETARY",
            "PRESIDENT",
            "CLUB_IN_CHARGE",
            "SUPER_ADMIN",
            "ADMIN",
            "USER"
        ],
        "calendar/date" => [
            "MEMBER",
            "TREASURER",
            "SECRETARY",
            "PRESIDENT",
            "CLUB_IN_CHARGE",
            "SUPER_ADMIN",
            "ADMIN",
            "USER"
        ],
        "profile" => [
            "MEMBER",
            "TREASURER",
            "SECRETARY",
            "PRESIDENT",
            "CLUB_IN_CHARGE",
            "SUPER_ADMIN",
            "ADMIN",
            "USER"
        ],
        "profile/public" => [
            "MEMBER",
            "TREASURER",
            "SECRETARY",
            "PRESIDENT",
            "CLUB_IN_CHARGE",
            "SUPER_ADMIN",
            "ADMIN",
            "USER"
        ],
        "profile/edit" => [
            "MEMBER",
            "TREASURER",
            "SECRETARY",
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
            "SECRETARY",
            "PRESIDENT",
            "CLUB_IN_CHARGE",
            "SUPER_ADMIN",
            "ADMIN",
            "USER"
        ],
        "events/event" => [
            "ANY"
        ],
        "events/scroll" => [
            "MEMBER",
            "TREASURER",
            "SECRETARY",
            "PRESIDENT",
            "CLUB_IN_CHARGE",
            "SUPER_ADMIN",
            "ADMIN",
            "USER"
        ],
        /* event dashboard routes */
        "events/dashboard" => [
            "MEMBER",
            "TREASURER",
            "SECRETARY",
            "PRESIDENT",
            "CLUB_IN_CHARGE",
        ],
        "events/dashboard/details" => [
            "MEMBER",
            "TREASURER",
            "SECRETARY",
            "PRESIDENT",
            "CLUB_IN_CHARGE",
        ],
        "events/dashboard/registrations" => [
            "MEMBER",
            "TREASURER",
            "SECRETARY",
            "PRESIDENT",
            "CLUB_IN_CHARGE",
        ],
        "events/dashboard/registrations/add" => [
            "MEMBER",
            "TREASURER",
            "SECRETARY",
            "PRESIDENT",
            "CLUB_IN_CHARGE",
        ],
        "events/dashboard/registrations/attendance" => [
            "MEMBER",
            "TREASURER",
            "SECRETARY",
            "PRESIDENT",
            "CLUB_IN_CHARGE",
        ],
        "events/dashboard/sponsors" => [
            "MEMBER",
            "TREASURER",
            "SECRETARY",
            "PRESIDENT",
            "CLUB_IN_CHARGE",
        ],
        "events/dashboard/estimates" => [
            "TREASURER",
            "SECRETARY",
            "PRESIDENT",
            "CLUB_IN_CHARGE",
        ],
        "events/dashboard/budgets" => [
            "MEMBER",
            "TREASURER",
            "SECRETARY",
            "PRESIDENT",
            "CLUB_IN_CHARGE",
        ],
        "events/dashboard/agenda" => [
            "MEMBER",
            "TREASURER",
            "SECRETARY",
            "PRESIDENT",
            "CLUB_IN_CHARGE",
        ],
        "events/dashboard/announcements" => [
            "MEMBER",
            "TREASURER",
            "SECRETARY",
            "PRESIDENT",
            "CLUB_IN_CHARGE",
        ],
        "events/dashboard/complains" => [
            "MEMBER",
            "TREASURER",
            "SECRETARY",
            "PRESIDENT",
            "CLUB_IN_CHARGE",
        ],
        /* club routes */
        "club" => [
            "MEMBER",
            "TREASURER",
            "SECRETARY",
            "PRESIDENT",
            "CLUB_IN_CHARGE",
            "SUPER_ADMIN",
            "ADMIN",
        ],
        /* club dashboard routes */
        "club/dashboard" => [
            "MEMBER",
            "TREASURER",
            "SECRETARY",
            "PRESIDENT",
            "CLUB_IN_CHARGE",
            "SUPER_ADMIN",
            "ADMIN",
        ],
        "club/dashboard/events/add" => [
            "PRESIDENT",
            "CLUB_IN_CHARGE",
        ],
        "club/dashboard/events/edit" => [
            "PRESIDENT",
            "CLUB_IN_CHARGE",
        ],
        "club/dashboard/members" => [
            "SECRETARY",
            "PRESIDENT",
            "CLUB_IN_CHARGE",
        ],
        "club/dashboard/meetings" => [
            "SECRETARY",
            "PRESIDENT",
            "CLUB_IN_CHARGE",
        ],
        "club/dashboard/meetings/add" => [
            "SECRETARY",
            "PRESIDENT",
            "CLUB_IN_CHARGE",
        ],
        "club/dashboard/meetings/meeting-attendence" => [
            "SECRETARY",
            "PRESIDENT",
            "CLUB_IN_CHARGE",
        ],
        "club/dashboard/reports" => [
            "SECRETARY",
            "PRESIDENT",
            "CLUB_IN_CHARGE",
        ],
        "club/dashboard/reports/add" => [
            "SECRETARY",
            "PRESIDENT",
            "CLUB_IN_CHARGE",
        ],
        "club/dashboard/community" => [
            "MEMBER",
            "TREASURER",
            "SECRETARY",
            "PRESIDENT",
            "CLUB_IN_CHARGE",
        ],
        "club/dashboard/community/scroll" => [
            "MEMBER",
            "TREASURER",
            "SECRETARY",
            "PRESIDENT",
            "CLUB_IN_CHARGE",
        ],
        "club/dashboard/requests" => [
            "CLUB_IN_CHARGE",
            "PRESIDENT",
        ],
        "club/dashboard/requests/add" => [
            "CLUB_IN_CHARGE",
            "PRESIDENT",
        ],
        "club/dashboard/requests/edit" => [
            "CLUB_IN_CHARGE",
            "PRESIDENT",
        ],
        "club/dashboard/posts" => [
            "MEMBER",
            "TREASURER",
            "SECRETARY",
            "PRESIDENT",
            "CLUB_IN_CHARGE",
        ],
        "club/dashboard/posts/add" => [
            "MEMBER",
            "TREASURER",
            "SECRETARY",
            "PRESIDENT",
            "CLUB_IN_CHARGE",
        ],
        "club/dashboard/posts/edit" => [
            "MEMBER",
            "TREASURER",
            "SECRETARY",
            "PRESIDENT",
            "CLUB_IN_CHARGE",
        ],
        "club/dashboard/logs" => [
            "TREASURER",
            "SECRETARY",
            "PRESIDENT",
            "CLUB_IN_CHARGE",
        ],
        "club/dashboard/election" => [
            "MEMBER",
            "TREASURER",
            "SECRETARY",
            "PRESIDENT",
            "CLUB_IN_CHARGE",
        ],
        "club/dashboard/election/result" => [
            "MEMBER",
            "TREASURER",
            "SECRETARY",
            "PRESIDENT",
            "CLUB_IN_CHARGE",
        ],
        "club/dashboard/election/vote" => [
            "MEMBER",
            "TREASURER",
            "SECRETARY",
            "PRESIDENT",
            "CLUB_IN_CHARGE",
        ],
        "club/dashboard/election/details" => [
            "MEMBER",
            "TREASURER",
            "SECRETARY",
            "PRESIDENT",
            "CLUB_IN_CHARGE",
        ],
        "club/dashboard/election/add" => [
            "PRESIDENT",
            "CLUB_IN_CHARGE",
        ],
        "club/dashboard/election/edit" => [
            "PRESIDENT",
            "CLUB_IN_CHARGE",
        ],
        /* super admin routes */
        "admin/dashboard" => [
            "SUPER_ADMIN"
        ],
        "admin/dashboard/club/add" => [
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
        /* notification routes */
        "notification" => [
            "MEMBER",
            "TREASURER",
            "SECRETARY",
            "PRESIDENT",
            "CLUB_IN_CHARGE",
            "SUPER_ADMIN",
            "ADMIN",
            "USER"
        ],
        "notification/read" => [
            "MEMBER",
            "TREASURER",
            "SECRETARY",
            "PRESIDENT",
            "CLUB_IN_CHARGE",
            "SUPER_ADMIN",
            "ADMIN",
            "USER"
        ],
        "notification/delete" => [
            "MEMBER",
            "TREASURER",
            "SECRETARY",
            "PRESIDENT",
            "CLUB_IN_CHARGE",
            "SUPER_ADMIN",
            "ADMIN",
            "USER"
        ],
    ];
}
