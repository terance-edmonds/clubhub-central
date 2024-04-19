<?php

class ClubMemberDocuments extends Modal
{
    protected $table = "club_member_documents";
    protected $allowed_columns = [
        "club_id",
        "user_id",
        "document",
        "club_member_id",
    ];

    public function validateCreate($data)
    {
        $this->errors = [];

        if (empty($data['user_id'])) $this->errors['user_id'] = "User ID is required";
        if (empty($data['club_id'])) $this->errors['club_id'] = "Club ID is required";
        if (empty($data['document'])) $this->errors['document'] = "document is required";
        if (empty($data['club_member_id'])) $this->errors['club_member_id'] = "Club Member ID is required";

        if (empty($this->errors)) {
            return true;
        }

        return false;
    }
}
