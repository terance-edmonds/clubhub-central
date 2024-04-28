<?php

class UserPasswordToken extends Modal
{
    protected $table = "user_password_tokens";
    protected $allowed_columns = [
        "user_id",
        "token",
        "created_datetime",
        "email",
        "is_used"
    ];

    public function validateCreate($data)
    {
        $this->errors = [];
        $pattern = '/^[a-zA-Z0-9._%+-]+@(?:stu\.ucsc\.cmb\.ac\.lk|ucsc\.cmb\.ac\.lk)$/';

        /* check email format preg_match($pattern, $email) */
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = "Email is not valid";
        } else if (!preg_match($pattern, $data['email'])) {
            $this->errors['email'] = "Email is not allowed ( allowed only emails in '@stu.ucsc.cmb.ac.lk' or '@ucsc.cmb.ac.lk' format )";
            /* check if the email is in valid format */
        }

        if (empty($this->errors)) {
            return true;
        }

        return false;
    }
}
