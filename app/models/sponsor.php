<?php

class Sponsor extends Modal
{
    protected $table = "club_event_sponsors";
    protected $allowed_columns = [
        "club_id",
        "club_event_id",
        "name",
        "contact_person",
        "contact_number",
        "email",
        "amount"
    ];
    protected $search_columns = [
        "name",
        "contact_person",
        "contact_number",
        "email",
    ];

    public function validateCreateSponsor($data)
    {
        $this->errors = [];

        if (empty($data['club_id'])) $this->errors['club_id'] = "Club ID is required";
        if (empty($data['club_event_id'])) $this->errors['club_event_id'] = "Event ID is required";
        if (empty($data['name'])) $this->errors['name'] = "Package name is required";
        if (empty($data['contact_person'])) $this->errors['contact_person'] = "Person name is required";
        if (empty($data['contact_number'])) {
            $this->errors['contact_number'] = "Contact Number is required";
        } else if (strlen($data['contact_number']) != 10) {
            $this->errors['user_contact'] = "Contact no. must have 10 digits";
        }
        if (empty($data['email'])) {
            $this->errors['email'] = "Email is required";
        } else if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = "Email is not valid";
        };
        if (empty($data['amount'])) $this->errors['amount'] = "Amount is required";
        if ($data['amount'] < 0) {
            $this->errors['amount'] = "Amount is not valid";
        }

        if (empty($this->errors)) {
            return true;
        }

        return false;
    }

    public function validateEditSponsor($data)
    {
        $this->errors = [];

        if (empty($data['name'])) $this->errors['name'] = "Package name is required";
        if (empty($data['contact_person'])) $this->errors['contact_person'] = "Person name is required";
        if (empty($data['contact_number'])) {
            $this->errors['contact_number'] = "Contact Number is required";
        } else if (strlen($data['contact_number']) != 10) {
            $this->errors['contact_number'] = "Contact no. must have 10 digits";
        };
        if (empty($data['email'])) {
            $this->errors['email'] = "Email is required";
        } else if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = "Email is not valid";
        };
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
