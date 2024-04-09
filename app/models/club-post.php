<?php

class ClubPost extends Modal
{
    protected $table = "club_posts";
    protected $allowed_columns = [
        "club_id",
        "user_id",
        "post_name",
        "description",
        "image",
        "created_datetime",
        "is_deleted"
    ];
    protected $search_columns = [
        "club_posts.post_name",
        "club_posts.description",
    ];

    public function validateCreatePost($data)
    {
        $this->errors = [];

        if (empty($data['club_id'])) $this->errors['club_id'] = "Club ID is required";
        if (empty($data['user_id'])) $this->errors['user_id'] = "User ID is required";
        if (empty($data['post_name'])) $this->errors['post_name'] = "Name is Required";
        if (empty($data['description'])) $this->errors['description'] = "Description is Required";
        if (empty($data['image'])) $this->errors['images'] = "image is required";
        if (empty($data['created_datetime'])) $this->errors['created_datetime'] = "Created date & time is required";

        if (empty($this->errors)) {
            return true;
        }

        return false;
    }
}
