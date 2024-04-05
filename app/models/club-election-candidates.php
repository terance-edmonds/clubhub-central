<?php

class ClubElectionCandidates extends Modal
{
    protected $table = "club_election_candidates";
    protected $allowed_columns = [
        "club_id",
        "user_id",
        "election_id",
        "club_member_id",
        "role"
    ];

    public function validateCreate($data)
    {
        $this->errors = [];

        if (empty($data['club_id'])) $this->errors['club_id'] = "Club ID is required";
        if (empty($data['user_id'])) $this->errors['user_id'] = "User ID is required";
        if (empty($data['election_id'])) $this->errors['election_id'] = "Election ID is required";
        if (empty($data['club_member_id'])) $this->errors['club_member_id'] = "Club member ID is required";
        if (empty($data['role'])) $this->errors['role'] = "Club member role is required";

        if (empty($this->errors)) {
            return true;
        }

        return false;
    }
}
