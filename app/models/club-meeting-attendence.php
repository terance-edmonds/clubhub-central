 <?php

class ClubMeetingAttendence extends Modal
{
    protected $table = "club_meeting_attendence";
    protected $allowed_columns = [
        "club_id",
        "meeting_id",
        "user_name",
        "user_email",
        "attended"
    ];
    protected $search_columns = [
        "user_name",
        "user_email"
    ];

    public function validateAddMeeting($data)
    {
        $this->errors = [];

        if (empty($data['club_id'])) $this->errors['club_id'] = "Club ID is required";
        if (empty($data['meeting_id'])) $this->errors['meeting_id'] = "Meeting ID is required";
        if (empty($data['user_name'])) $this->errors['name'] = "Name is required";
        if (empty($data['user_email'])) $this->errors['date'] = "Date is required";

        if (empty($this->errors)) {
            return true;
        }
        return false;
    }
}