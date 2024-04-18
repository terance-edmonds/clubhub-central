<?php

class UserNotificationsState extends Modal
{
    protected $table = "user_notification_state";
    protected $allowed_columns = [
        "user_id",
        "notification_id",
        "mark_as_read",
    ];

    public function validateCreate($data)
    {
        $this->errors = [];

        if (empty($data['user_id'])) $this->errors['user_id'] = "User ID is required";
        if (empty($data['notification_id'])) $this->errors['notification_id'] = "Notification ID is required";

        if (empty($this->errors)) {
            return true;
        }

        return false;
    }

    public function validateUpdate($data)
    {
        $this->errors = [];

        if (empty($data['id'])) $this->errors['id'] = "ID is required";
        if (empty($data['mark_as_read'])) $this->errors['mark_as_read'] = "Read state is required";

        if (empty($this->errors)) {
            return true;
        }

        return false;
    }
}
