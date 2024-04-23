 <?php

class ClubMeeting extends Modal
{
    protected $table = "club_meeting";
    protected $allowed_columns = [
        "club_id",
        "name",
        "date",
        "start_time",
        "participants",
        "type",
        "attendence"
    ];
    protected $search_columns = [
        "name",
        "date"
    ];

    public function validateAddMeeting($data)
    {
        $this->errors = [];

        if (empty($data['club_id'])) $this->errors['club_id'] = "Club ID is required";
        if (empty($data['name'])) $this->errors['name'] = "Name is required";
        if (empty($data['date'])) $this->errors['date'] = "Date is required";
        if (empty($data['start_time'])) $this->errors['start_time'] = "Start Time is required";
        if (empty($data['participants'])) $this->errors['participants'] = "participants is required";
        if (empty($data['type'])) $this->errors['type'] = "type is required";



        if (empty($this->errors)) {
            return true;
        }
        return false;
    }
}