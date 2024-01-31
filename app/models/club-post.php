<?php

class ClubPost extends Modal
{
    protected $table = "club_posts";
    protected $allowed_columns = [
        "club_id",
        "post_name",
        "description",
        "images",
        "created_date"
    ];

    public function validateCreatePost($data)
    {
        $this->errors = [];

        if (empty($data['club_id'])) $this->errors['club_id'] = "Club ID is required";
        // if (empty($data['post_name'])) $this->errors['post_name'] = "Name is Required";
        // if (empty($data['description'])) $this->errors['description'] = "Description is Required";
        // if (empty($data['images'])) $this->errors['images'] = "image is required";
        if (empty($data['created_datetime'])) $this->errors['created_datetime'] = "Created date & time is required";

        if (empty($this->errors)) {
            return true;
        }

        return false;
    }
}