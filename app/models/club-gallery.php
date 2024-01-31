<?php

class ClubGallery extends Modal
{
    protected $table = "club_gallery";
    protected $allowed_columns = [
        "club_id",
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