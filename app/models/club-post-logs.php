<?php

class ClubPostLogs extends Modal
{
    protected $table = "club_post_logs";
    protected $allowed_columns = [
        "club_id",
        "club_member_id",
        "user_id",
        "description",
        "club_post_id"
    ];
}
