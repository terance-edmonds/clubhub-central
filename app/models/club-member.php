<?php

class ClubMember extends Modal
{
    protected $table = "club_members";
    protected $allowed_columns = [
        "club_id",
        "user_id",
        "role",
        "state",
    ];

    public function validateCreate($data)
    {
        $this->errors = [];

        if (empty($data['user_id'])) $this->errors['user_id'] = "User ID is required";
        if (empty($data['club_id'])) $this->errors['club_id'] = "Club ID is required";
        if (empty($data['role'])) $this->errors['role'] = "Role is required";

        /* check if nic exists */
        if ($this->one(['user_id' => $data['user_id'], 'club_id' => $data['club_id']])) {
            $this->errors['user_id'] = "User already assigned to the club";
        }

        if (empty($this->errors)) {
            return true;
        }

        return false;
    }
}
