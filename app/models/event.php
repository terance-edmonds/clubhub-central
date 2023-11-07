<?php

class Event extends Modal
{
    protected $table = "club_events";
    protected $allowed_columns = [
        "club_id",
        "name",
        "description",
        "venue",
        "start_datetime",
        "end_datetime",
        "is_public",
        "image",
        "state",
        "open_registration",
        "created_datetime",
    ];

    public function validateCreateEvent($data)
    {
        $this->errors = [];

        if (empty($data['name'])) $this->errors['name'] = "Name is required";
        if (empty($data['venue'])) $this->errors['venue'] = "Venue is required";
        if (empty($data['start_datetime'])) $this->errors['start_datetime'] = "Start date & time is required";
        if (empty($data['end_datetime'])) $this->errors['end_datetime'] = "End date & time is required";
        if (empty($data['description'])) $this->errors['description'] = "Description is required";
        if (empty($data['created_datetime'])) $this->errors['created_datetime'] = "Created date & time is required";

        if ($data['end_datetime'] > $data['start_datetime']) {
            $this->errors['end_datetime'] = "Invalid end date & time";
        }

        $groups_errors = [];
        foreach ($data['groups'] as $key => $group) {
            $group_errors = [];

            if (empty($group['name'])) $group_errors['name'] = 'Group name is required';

            $groups_errors[$key] = $group_errors;
        }

        if (count($groups_errors) > 0) {
            $this->errors['groups'] =  $groups_errors;
        }

        if (empty($this->errors)) {
            return true;
        }

        return false;
    }
}
