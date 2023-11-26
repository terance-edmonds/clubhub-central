<?php

class UserGallery extends Modal
{
    protected $table = "user_gallery";
    protected $allowed_columns = [
        "user_id",
        "image",
    ];

    public function validateAddImage($data)
    {
        $this->errors = [];

        if (empty($data['image']))
            $this->errors['image'] = "Image is required";

        if (empty($this->errors)) {
            return true;
        }

        return false;
    }
}
