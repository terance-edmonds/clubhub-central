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
        if (empty($data['image'])) $this->errors['image'] = "Image is required";
        if (empty($data['start_datetime'])) $this->errors['start_datetime'] = "Start date & time is required";
        if (empty($data['end_datetime'])) $this->errors['end_datetime'] = "End date & time is required";
        if (empty($data['description'])) $this->errors['description'] = "Description is required";
        if (empty($data['created_datetime'])) $this->errors['created_datetime'] = "Created date & time is required";

        if ($data['start_datetime'] > $data['end_datetime']) {
            $this->errors['end_datetime'] = "Invalid end date & time";
        }

        if (empty($this->errors)) {
            return true;
        }

        return false;
    }

    public function validateUpdateEvent($data)
    {
        $this->errors = [];

        if (empty($data['name'])) $this->errors['name'] = "Name is required";
        if (empty($data['venue'])) $this->errors['venue'] = "Venue is required";
        if (empty($data['start_datetime'])) $this->errors['start_datetime'] = "Start date & time is required";
        if (empty($data['end_datetime'])) $this->errors['end_datetime'] = "End date & time is required";
        if (empty($data['description'])) $this->errors['description'] = "Description is required";

        if ($data['start_datetime'] > $data['end_datetime']) {
            $this->errors['end_datetime'] = "Invalid end date & time";
        }

        if (empty($this->errors)) {
            return true;
        }

        return false;
    }
}
