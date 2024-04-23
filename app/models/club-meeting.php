 <?php

    class ClubMeeting extends Modal
    {
        protected $table = "club_meeting";
        protected $allowed_columns = [
            "club_id",
            "name",
            "date",
            "start_time",
            "end_time",
            "venue",
            "participants",
            "type",
            "attendance",
            "description"
        ];
        protected $search_columns = [
            "name",
            "venue",
            "description",
        ];

        public function validateAddMeeting($data)
        {
            $this->errors = [];

            if (empty($data['name'])) $this->errors['name'] = "Name is required";
            if (empty($data['date'])) $this->errors['date'] = "Date is required";
            if (empty($data['start_time'])) $this->errors['start_time'] = "Start Time is required";
            if (empty($data['end_time'])) $this->errors['end_time'] = "End Time is required";
            if (empty($data['venue'])) $this->errors['venue'] = "Venue is required";
            if (empty($data['type'])) $this->errors['type'] = "Type is required";



            if (empty($this->errors)) {
                return true;
            }
            return false;
        }
    }
