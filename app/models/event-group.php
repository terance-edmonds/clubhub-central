<?php

class EventGroup extends Modal
{
    protected $table = "club_event_groups";
    protected $allowed_columns = [
        "club_id",
        "club_event_id",
        "name",
        "budget_permission",
        "detail_permission",
        "registration_permission",
        "sponsor_permission"
    ];

    public function validateCreateEventGroup($data)
    {
        $this->errors = [];

        if (empty($data['name'])) $this->errors['name'] = "Name is required";

        if (empty($this->errors)) {
            return true;
        }
        return false;
    }
}
