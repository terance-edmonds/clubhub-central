<?php

class ClubRequest extends Modal
{
    protected $table = "club_requests";
    protected $allowed_columns = [
        "club_id",
        "club_event_id",
        "subject",
        "description",
        "remarks",
        "state",
    ];
    protected $search_columns = [
        "club_requests.subject",
        "club_requests.description"
    ];

    public function validateCreateRequest($data)
    {
        $this->errors = [];

        if (empty($data['club_id'])) $this->errors['club_id'] = "Club ID is required";
        if (empty($data['club_event_id'])) $this->errors['club_event_id'] = "Club Event ID is required";
        if (empty($data['subject'])) $this->errors['subject'] = "Subject is Required";
        if (empty($data['description'])) $this->errors['description'] = "Description is Required";

        if (empty($this->errors)) {
            return true;
        }

        return false;
    }

    public function validateUpdateRequest($data)
    {
        $this->errors = [];

        if (empty($data['id'])) $this->errors['id'] = "ID is required";
        if (empty($data['club_event_id'])) $this->errors['club_event_id'] = "Club Event ID is required";
        if (empty($data['club_id'])) $this->errors['club_id'] = "Club ID is required";
        if (empty($data['subject'])) $this->errors['subject'] = "Subject is Required";
        if (empty($data['description'])) $this->errors['description'] = "Description is Required";

        if (empty($this->errors)) {
            return true;
        }

        return false;
    }

    public function validateUpdateRequestState($data)
    {
        $this->errors = [];

        if (empty($data['id'])) $this->errors['id'] = "ID is required";
        if (empty($data['state'])) $this->errors['state'] = "State is Required";

        if (empty($this->errors)) {
            return true;
        }

        return false;
    }
}
