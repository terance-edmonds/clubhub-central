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
            $data['president'] == $data['secretary'] ||
            $data['president'] == $data['treasurer']
        ) {
            $this->errors['president'] = "Each candidate is eligible to be voted only for one designation";
        }
        if (
            $data['secretary'] == $data['president'] ||
            $data['secretary'] == $data['treasurer']
        ) {
            $this->errors['secretary'] = "Each candidate is eligible to be voted only for one designation";
        }
        if (
            $data['treasurer'] == $data['secretary'] ||
            $data['treasurer'] == $data['president']
        ) {
            $this->errors['treasurer'] = "Each candidate is eligible to be voted only for one designation";
        }

        if (empty($this->errors)) {
            return true;
        }

        return false;
    }
}
