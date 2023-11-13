<?php

class Package extends Modal
{
    protected $table = "club_event_packages";
    protected $allowed_columns = [
        "club_id",
        "club_event_id",
        "name",
        "amount"
    ];
    protected $search_columns = [
        "name"
    ];

    public function validateCreatePackage($data)
    {
        $this->errors = [];

        if (empty($data['club_id'])) $this->errors['club_id'] = "Club ID is required";
        if (empty($data['club_event_id'])) $this->errors['club_event_id'] = "Event ID is required";
        if (empty($data['name'])) $this->errors['name'] = "Package name is required";
        if (empty($data['amount'])) $this->errors['amount'] = "Amount is required";

        if ($data['amount'] < 0) {
            $this->errors['amount'] = "Amount is not valid";
        }

        if (empty($this->errors)) {
            return true;
        }

        return false;
    }

    public function validateEditPackage($data)
    {
        $this->errors = [];

        if (empty($data['name'])) $this->errors['name'] = "Package name is required";
        if (empty($data['amount'])) $this->errors['amount'] = "Amount is required";

        if ($data['amount'] < 0) {
            $this->errors['amount'] = "Amount is not valid";
        }

        if (empty($this->errors)) {
            return true;
        }

        return false;
    }
}
