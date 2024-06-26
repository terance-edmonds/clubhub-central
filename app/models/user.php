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
        "image",
        "is_blacklisted",
        "is_verified",
        "is_deleted",
        "description"
    ];
    protected $search_columns = [
        "first_name",
        "last_name",
        "email"
    ];

    public function validateLogin($data)
    {
        $this->errors = [];
        $pattern = '/^[a-zA-Z0-9._%+-]+@(?:stu\.ucsc\.cmb\.ac\.lk|ucsc\.cmb\.ac\.lk)$/';

        // TODO: update pattern validation
        /* check email format preg_match($pattern, $email) */
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = "Email is not valid";
            /* check if the email is in valid format */
        } else if (!preg_match($pattern, $data['email'])) {
            $this->errors['email'] = "Email is not allowed ( allowed only emails in '@stu.ucsc.cmb.ac.lk' or '@ucsc.cmb.ac.lk' format )";
        }

        if (empty($data['password'])) $this->errors['password'] = "Password is required";

        if (empty($this->errors)) {
            return true;
        }

        return false;
    }

    public function validateRegister($data)
    {
        $this->errors = [];
        $pattern = '/^[a-zA-Z0-9._%+-]+@(?:stu\.ucsc\.cmb\.ac\.lk|ucsc\.cmb\.ac\.lk)$/';

        if (empty($data['first_name'])) $this->errors['first_name'] = "First name is required";
        if (empty($data['last_name'])) $this->errors['last_name'] = "Last name is required";
        if (empty($data['email'])) $this->errors['email'] = "Email is required";

        if (empty($data['password'])) $this->errors['password'] = "Password is required";
        if (strlen($data['password']) < 8) $this->errors['password'] = "Password must be at least 8 characters";
        if (empty($data['confirm_password'])) $this->errors['password'] = "Confirm password is required";
        if ($data['password'] !== $data['confirm_password']) {
            $this->errors['password'] = "Passwords does not match";
        }
        // TODO: update pattern validation
        /* check email format preg_match($pattern, $email) */
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = "Email is not valid";
        } else if (!preg_match($pattern, $data['email'])) {
            /* check if the email is in valid format */
            $this->errors['email'] = "Email is not allowed ( allowed only emails in '@stu.ucsc.cmb.ac.lk' or '@ucsc.cmb.ac.lk' format )";
        } else if ($this->one(['email' => $data['email']])) {
            /* check if email exists */
            $this->errors['email'] = "Email already exists";
        }

        if (empty($this->errors)) {
            return true;
        }

        return false;
    }

    public function validateUpdate($data)
    {
        $this->errors = [];

        if (empty($data['first_name'])) $this->errors['first_name'] = "First name is required";
        if (empty($data['last_name'])) $this->errors['last_name'] = "Last name is required";

        if (empty($this->errors)) {
            return true;
        }

        return false;
    }

    public function validateChangePassword($data)
    {
        $this->errors = [];
        $auth_user = Auth::user();

        if (empty($data['current_password'])) $this->errors['current_password'] = "Current password is required";
        if (empty($data['new_password'])) $this->errors['new_password'] = "New password is required";
        if (strlen($data['new_password']) < 8) $this->errors['new_password'] = "New Password must be at least 8 characters";
        if (empty($data['confirm_new_password'])) $this->errors['confirm_new_password'] = "Confirm new password is required";
        if ($data['new_password'] !== $data['confirm_new_password']) {
            $this->errors['new_password'] = "New Passwords does not match";
        }

        /* validate current password */
        $result = $this->one(['id' => $auth_user["id"]]);
        if (!password_verify($_POST['current_password'], $result->password)) {
            $this->errors['current_password'] = "Invalid current password";
        }

        if (empty($this->errors)) {
            return true;
        }

        return false;
    }

    public function validateResetPassword($data)
    {
        $this->errors = [];

        if (empty($data['new_password'])) $this->errors['new_password'] = "New password is required";
        if (strlen($data['new_password']) < 8) $this->errors['new_password'] = "New Password must be at least 8 characters";
        if (empty($data['confirm_new_password'])) $this->errors['confirm_new_password'] = "Confirm new password is required";
        if ($data['new_password'] !== $data['confirm_new_password']) {
            $this->errors['new_password'] = "New Passwords does not match";
        }

        if (empty($this->errors)) {
            return true;
        }

        return false;
    }
}
