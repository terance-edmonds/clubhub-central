<?php

class Agenda extends Modal
{
    protected $table = "club_event_agenda";
    protected $allowed_columns = [
        "club_id",
        "club_event_id",
        "name",
        "note",
        "venue",
        "start_datetime",
        "end_datetime",
    ];
    protected $search_columns = [
        "name",
        "note",
        "venue"
    ];

    public function validateAddEventAgenda($data)
    {
        $this->errors = [];

        if (empty($data['name'])) $this->errors['name'] = "Name is required";
        if (empty($data['venue'])) $this->errors['venue'] = "Venue is required";
        if (empty($data['start_datetime'])) $this->errors['start_datetime'] = "Start date & time is required";
        if (empty($data['end_datetime'])) $this->errors['end_datetime'] = "End date & time is required";

        if (empty($this->errors)) {
            return true;
        }

        return false;
    }
}
