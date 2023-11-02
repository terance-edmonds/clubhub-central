<?php

class Clubs extends Modal
{
    protected $table = "clubs";
    protected $allowed_columns = [
        "name",
        "description",
        "image",
        "state",
        "is_deleted",
        "created_datetime",
        "club_in_charge_email"
    ];

    public function validateCreateClub($data)
    {
        $this->errors = [];

        if (empty($data['name'])) $this->errors['name'] = "Name is required";
        if (empty($data['club_in_charge_email'])) $this->errors['club_in_charge_email'] = "Club in charge email is required";
        if (empty($data['created_datetime'])) $this->errors['created_datetime'] = "Created date & time is required";

        if (empty($this->errors)) {
            return true;
        }
        return false;
    }
}
