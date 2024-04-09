<?php

class ClubElection extends Modal
{
    protected $table = "club_elections";
    protected $allowed_columns = [
        "club_id",
        "title",
        "description",
        "state",
        "public_results",
        "start_datetime",
        "end_datetime",
        "is_deleted"
    ];
    protected $search_columns = [
        "title",
        "description",
    ];

    public function validateCreate($data)
    {
        $this->errors = [];

        if (empty($data['club_id'])) $this->errors['club_id'] = "Club ID is required";
        if (empty($data['title'])) $this->errors['title'] = "Title is required";
        if (empty($data['start_datetime'])) $this->errors['start_datetime'] = "Start date & time is required";
        if (empty($data['end_datetime'])) $this->errors['end_datetime'] = "End date & time is required";
        if (empty($data['voter']) || count($data['voter']) == 0) $this->errors['voter'] = "At least one voter is required";

        if (empty($this->errors)) {
            return true;
        }

        return false;
    }

    public function validateUpdate($data)
    {
        $this->errors = [];

        if (empty($data['id'])) $this->errors['id'] = "Election ID is required";
        if (empty($data['club_id'])) $this->errors['club_id'] = "Club ID is required";
        if (empty($data['title'])) $this->errors['title'] = "Title is required";
        if (empty($data['start_datetime'])) $this->errors['start_datetime'] = "Start date & time is required";
        if (empty($data['end_datetime'])) $this->errors['end_datetime'] = "End date & time is required";
        if (empty($data['voter']) || count($data['voter']) == 0) $this->errors['voter'] = "At least one voter is required";

        if (empty($this->errors)) {
            return true;
        }

        return false;
    }
}
