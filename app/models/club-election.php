<?php

class ClubElection extends Modal
{
    protected $table = "club_elections";
    protected $allowed_columns = [
        "club_id",
        "title",
        "description",
        "state",
        "public_results",
        "start_datetime",
        "end_datetime",
        "is_deleted"
    ];
    protected $search_columns = [
        "title",
        "description",
    ];

    public function validateCreate($data)
    {
        $this->errors = [];

        if (empty($data['club_id'])) $this->errors['club_id'] = "Club ID is required";
        if (empty($data['title'])) $this->errors['title'] = "Title is required";
        if (empty($data['start_datetime'])) $this->errors['start_datetime'] = "Start date & time is required";
        if (empty($data['end_datetime'])) $this->errors['end_datetime'] = "End date & time is required";
        if (empty($data['voter']) || count($data['voter']) == 0) $this->errors['voter'] = "At least one voter is required";

        $roles = ['president', 'secretary', 'treasurer'];
        $candidate_members = array();
        foreach ($roles as $role) {
            if (!empty($data[$role . '_candidate']) && is_array($data[$role . '_candidate'])) {
                foreach ($data[$role . '_candidate'] as $candidate) {
                    array_push($candidate_members, $candidate['user_id']);
                }
            }
        }

        $vote_members = array();
        if (!empty($data['voter']) && is_array($data['voter'])) {
            foreach ($data['voter'] as $voter) {
                array_push($vote_members, $voter['user_id']);
            }
        }

        if (array_intersect($candidate_members, $vote_members)) {
            $this->errors['message'] = "Each user can be either a candidate or a voter.";
        }

        if (empty($this->errors)) {
            return true;
        }

        return false;
    }

    public function validateUpdate($data)
    {
        $this->errors = [];

        if (empty($data['id'])) $this->errors['id'] = "Election ID is required";
        if (empty($data['club_id'])) $this->errors['club_id'] = "Club ID is required";
        if (empty($data['title'])) $this->errors['title'] = "Title is required";
        if (empty($data['start_datetime'])) $this->errors['start_datetime'] = "Start date & time is required";
        if (empty($data['end_datetime'])) $this->errors['end_datetime'] = "End date & time is required";
        if (empty($data['voter']) || count($data['voter']) == 0) $this->errors['voter'] = "At least one voter is required";

        $roles = ['president', 'secretary', 'treasurer'];
        $candidate_members = array();
        foreach ($roles as $role) {
            if (!empty($data[$role . '_candidate']) && is_array($data[$role . '_candidate'])) {
                foreach ($data[$role . '_candidate'] as $candidate) {
                    array_push($candidate_members, $candidate['user_id']);
                }
            }
        }

        $vote_members = array();
        if (!empty($data['voter']) && is_array($data['voter'])) {
            foreach ($data['voter'] as $voter) {
                array_push($vote_members, $voter['user_id']);
            }
        }

        if (array_intersect($candidate_members, $vote_members)) {
            $this->errors['message'] = "Each user can be either a candidate or a voter.";
        }

        if (empty($this->errors)) {
            return true;
        }

        return false;
    }
}
