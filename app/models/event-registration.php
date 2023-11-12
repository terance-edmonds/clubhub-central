<?php

class EventRegistration extends Modal
{
    protected $table = "club_event_registrations";
    protected $allowed_columns = [
        "club_id",
        "club_event_id",
        "user_name",
        "user_email",
        "user_contact",
        "attended",
    ];

    public function validateAddEventRegistration($data)
    {
        $this->errors = [];

        if (empty($data['user_name'])) $this->errors['user_name'] = "Name is required";
        if (empty($data['user_email'])) $this->errors['user_email'] = "Email is required";
        if (empty($data['user_contact'])) $this->errors['user_contact'] = "Contact no. is required";

        /* check if email exists */
        if (!filter_var($data['user_email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors['user_email'] = "Email is not valid";
        } else if ($this->one(['user_email' => $data['user_email']])) {
            $this->errors['user_email'] = "Email already exists";
        }

        if (empty($this->errors)) {
            return true;
        }

        return false;
    }

    public function validateUpdateEventRegistration($data)
    {
        $this->errors = [];

        if (empty($data['id'])) $this->errors['id'] = "ID is required";
        if (empty($data['user_name'])) $this->errors['user_name'] = "Name is required";
        if (empty($data['user_email'])) $this->errors['user_email'] = "Email is required";
        if (empty($data['user_contact'])) $this->errors['user_contact'] = "Contact no. is required";

        /* check if email exists */
        if (!filter_var($data['user_email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors['user_email'] = "Email is not valid";
        } else {
            $result = $this->one(['user_email' => $data['user_email']]);

            if ($result->id != $data['id']) {
                $this->errors['user_email'] = "Email already exists";
            }
        }

        if (empty($this->errors)) {
            return true;
        }

        return false;
    }
}
