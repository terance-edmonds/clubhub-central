<?php

class EventGroupMember extends Modal
{
    protected $table = "club_event_group_members";
    protected $allowed_columns = [
        "club_id",
        "club_event_id",
        "club_user_id",
        "club_event_group_id",
        "club_member_id",
    ];
}
