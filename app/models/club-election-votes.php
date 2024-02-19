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
    ];

    public function validateCreate($data)
    {
        $this->errors = [];

        if (empty($data['club_id'])) $this->errors['club_id'] = "Club ID is required";
        if (empty($data['voter_id'])) $this->errors['voter_id'] = "Voter ID is required";
        if (empty($data['club_election_id'])) $this->errors['club_election_id'] = "Election ID is required";

        if (empty($this->errors)) {
            return true;
        }

        return false;
    }
}
