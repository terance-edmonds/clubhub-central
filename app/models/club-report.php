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

        if (empty($data['report_name'])) $this->errors['report_name'] = "Report name is required";
        if (empty($data['report_type'])) $this->errors['report_type'] = "Report type is required";

        if (!empty($data['start_datetime']) && empty($data['end_datetime']))  $this->errors['end_datetime'] = "End date & time is required";
        if (!empty($data['end_datetime']) && empty($data['start_datetime']))  $this->errors['start_datetime'] = "Start date & time is required";

        if (!empty($data['start_datetime']) && !empty($data['end_datetime'])) {
            if ($data['start_datetime'] > $data['end_datetime']) {
                $this->errors['end_datetime'] = "Invalid end date & time";
            }
        }

        if (empty($this->errors)) {
            return true;
        }
        return false;
    }
}
