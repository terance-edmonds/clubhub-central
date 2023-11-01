<?php

class UserInvitation extends Modal
{
    protected $table = "user_invitations";
    protected $allowed_columns = [
        "user_id",
        "invitation_code",
        "is_valid",
        "club_role",
        "club_id"
    ];
}
