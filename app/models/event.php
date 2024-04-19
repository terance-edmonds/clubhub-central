<?php

class Event extends Modal
{
    protected $table = "club_events";
    protected $allowed_columns = [
        "club_id",
        "name",
        "description",
        "venue",
        "start_datetime",
        "end_datetime",
        "is_public",
        "image",
        "state",
        "open_registrations",
        "created_datetime",
        "is_budget_submitted",
        "president_budgets_verified",
        "president_budget_remarks",
        "incharge_budgets_verified",
        "incharge_budget_remarks",
        "is_deleted"
    ];
    protected $search_columns = [
        "name",
        "description",
        "venue"
    ];

    public function validateCreateEvent($data)
    {
        $this->errors = [];

        if (empty($data['name'])) $this->errors['name'] = "Name is required";
        if (empty($data['venue'])) $this->errors['venue'] = "Venue is required";
        if (empty($data['start_datetime'])) $this->errors['start_datetime'] = "Start date & time is required";
        if (empty($data['end_datetime'])) $this->errors['end_datetime'] = "End date & time is required";
        if (empty($data['description'])) $this->errors['description'] = "Description is required";
        if (empty($data['created_datetime'])) $this->errors['created_datetime'] = "Created date & time is required";

        if ($data['start_datetime'] > $data['end_datetime']) {
            $this->errors['end_datetime'] = "Invalid end date & time";
        }

        if (empty($this->errors)) {
            return true;
        }

        return false;
    }

    public function validateUpdateEvent($data)
    {
        $this->errors = [];

        if (empty($data['name'])) $this->errors['name'] = "Name is required";
        if (empty($data['venue'])) $this->errors['venue'] = "Venue is required";
        if (empty($data['start_datetime'])) $this->errors['start_datetime'] = "Start date & time is required";
        if (empty($data['end_datetime'])) $this->errors['end_datetime'] = "End date & time is required";
        if (empty($data['description'])) $this->errors['description'] = "Description is required";

        if ($data['start_datetime'] > $data['end_datetime']) {
            $this->errors['end_datetime'] = "Invalid end date & time";
        }

        if (empty($this->errors)) {
            return true;
        }

        return false;
    }

    public function validateBudgetReject($data)
    {
        $this->errors = [];

        if (empty($data['remarks'])) $this->errors['remarks'] = "Remarks is required";

        if (empty($this->errors)) {
            return true;
        }

        return false;
    }
}
