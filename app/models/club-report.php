<?php

class ClubReport extends Modal
{
    protected $table = "club_reports";
    protected $allowed_columns = [
        "club_id",
        "user_id",
        "club_member_id",
        "report_type",
        "report_name",
        "report_link",
        "start_datetime",
        "end_datetime",
        "created_datetime",
    ];
    protected $search_columns = [
        "club_reports.report_name",
        "club_reports.report_type"
    ];

    public function validateCreateReport($data)
    {
        $this->errors = [];

        if (empty($data['club_id'])) $this->errors['error'] = "Club ID is required";
        if (empty($data['user_id'])) $this->errors['error'] = "User ID is required";
        if (empty($data['club_member_id'])) $this->errors['error'] = "Club member ID is required";
        if (empty($data['report_name'])) $this->errors['report_name'] = "Report name is required";
        if (empty($data['report_type'])) $this->errors['report_type'] = "Report type is required";
        if (empty($data['report_link'])) $this->errors['error'] = "Report resource link is required";

        if (empty($this->errors)) {
            return true;
        }
        return false;
    }
}
