<?php

class ClubElection extends Modal
{
    protected $table = "club_elections";
    protected $allowed_columns = [
        "club_id",
        "title",
        "description",
        "is_public",
        "start_datetime",
        "end_datetime",
    ];

    public function validateCreate($data)
    {
        $this->errors = [];

        if (empty($data['club_id'])) $this->errors['club_id'] = "Club ID is required";
        if (empty($data['title'])) $this->errors['title'] = "Title is required";
        if (empty($data['start_datetime'])) $this->errors['start_datetime'] = "Start date & time is required";
        if (empty($data['end_datetime'])) $this->errors['end_datetime'] = "End date & time is required";

        if (empty($this->errors)) {
            return true;
        }

        return false;
    }
}
