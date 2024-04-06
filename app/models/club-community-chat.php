<?php

class ClubCommunityChat extends Modal
{
    protected $table = "club_community_chat";
    protected $allowed_columns = [
        "sender_user_id",
        "sender_club_member_id",
        "message",
        "club_id",
        "created_datetime",
    ];
    protected $search_columns = [
        "message"
    ];

    public function validateCreateMessage($data)
    {
        $this->errors = [];

        if (empty($data['sender_user_id'])) $this->errors['sender_user_id'] = "Sender user ID is required";
        if (empty($data['sender_club_member_id'])) $this->errors['sender_club_member_id'] = "Sender club member ID is required";
        if (empty($data['club_id'])) $this->errors['club_id'] = "Club ID is required";

        if (empty($this->errors)) {
            return true;
        }
        return false;
    }
}
