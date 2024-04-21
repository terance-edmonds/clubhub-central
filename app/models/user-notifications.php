<?php

class UserNotifications extends Modal
{
    protected $table = "user_notifications";
    protected $allowed_columns = [
        "title",
        "description",
        "link"
    ];

    public function validateCreate($data)
    {
        $this->errors = [];

        if (empty($data['title'])) $this->errors['title'] = "Title is required";
        if (empty($data['description'])) $this->errors['description'] = "Description is required";

        if (empty($this->errors)) {
            return true;
        }

        return false;
    }
}
