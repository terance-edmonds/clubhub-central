<?php

class ClubElectionVotes extends Modal
{
    protected $table = "club_election_votes";
    protected $allowed_columns = [
        "voter_id",
        "selected_candidate_id",
        "club_election_id",
        "description",
        "club_id",
        "role",
    ];

    public function validateCreate($data)
    {
        $this->errors = [];

        if (empty($data['club_id'])) $this->errors['club_id'] = "Club ID is required";
        if (empty($data['voter_id'])) $this->errors['voter_id'] = "Voter ID is required";
        if (empty($data['club_election_id'])) $this->errors['club_election_id'] = "Election ID is required";

        if (
            $data['president'] == $data['secretory'] ||
            $data['president'] == $data['treasurer']
        ) {
            $this->errors['president'] = "Each candidate is eligible to be voted only for one designation";
        }
        if (
            $data['secretory'] == $data['president'] ||
            $data['secretory'] == $data['treasurer']
        ) {
            $this->errors['secretory'] = "Each candidate is eligible to be voted only for one designation";
        }
        if (
            $data['treasurer'] == $data['secretory'] ||
            $data['treasurer'] == $data['treasurer']
        ) {
            $this->errors['treasurer'] = "Each candidate is eligible to be voted only for one designation";
        }

        if (empty($this->errors)) {
            return true;
        }

        return false;
    }
}
