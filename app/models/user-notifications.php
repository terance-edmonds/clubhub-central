<?php

class User extends Modal
{
    protected $table = "user_notifications";
    protected $allowed_columns = [
        "user_id",
        "for_all_users",
        "title",
        "description"
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
