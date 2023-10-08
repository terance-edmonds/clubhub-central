<?php

class User extends Modal
{
    protected $table = "users";
    protected $allowed_columns = [
        "email",
        "first_name",
        "last_name",
        "password",
        "role",
        "is_blacklisted",
        "is_verified"
    ];

    public function validate($data)
    {
        $this->errors = [];

        if (empty($data['first_name'])) $this->errors['first_name'] = "First name is required";
        if (empty($data['last_name'])) $this->errors['last_name'] = "Last name is required";
        if (empty($data['email'])) $this->errors['email'] = "Email is required";

        if (empty($data['password'])) $this->errors['password'] = "Password is required";
        if (empty($data['confirm_password'])) $this->errors['password'] = "Confirm password is required";
        if ($data['password'] !== $data['confirm_password']) {
            $this->errors['password'] = "Passwords does not match";
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = "Email is not valid";
        } else if ($this->find(['email' => $data['email']])) {
            $this->errors['email'] = "Email already exists";
        }

        if (empty($this->errors)) {
            return true;
        }

        return false;
    }
}
