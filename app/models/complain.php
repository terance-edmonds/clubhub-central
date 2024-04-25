<?php

class Complain extends Modal
{
    protected $table = "club_event_complains";
    protected $allowed_columns = [
        "club_id",
        "club_event_id",
        "complain"
    ];

    public function validateAddEventComplain($data)
    {
        $this->errors = [];

        if (empty($data['complain'])) $this->errors['complain'] = "Complain is required";

        if (empty($this->errors)) {
            return true;
        }

        return false;
    }
}
