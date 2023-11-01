<?php

class Budget extends Modal
{
    protected $table = "club_event_budgets";
    protected $allowed_columns = [
        "club_id",
        "club_event_id",
        "type",
        "name",
        "description",
        "amount",
        "from",
        "payment_type"
    ];

    public function validateAddIncome($data)
    {
        $this->errors = [];

        if (empty($data['club_id'])) $this->errors['club_id'] = "Club ID is required";
        if (empty($data['club_event_id'])) $this->errors['club_event_id'] = "Event ID is required";
        if (empty($data['type'])) $this->errors['type'] = "Type is required";
        if (empty($data['name'])) $this->errors['name'] = "Name is required";
        if (empty($data['amount'])) $this->errors['amount'] = "Amount is required";
        if (empty($data['from'])) $this->errors['from'] = "From is required";
        if (empty($data['payment_type'])) $this->errors['payment_type'] = "Payment type is required";

        if ($data['amount'] < 0) {
            $this->errors['amount'] = "Amount is not valid";
        }

        if (empty($this->errors)) {
            return true;
        }
        return false;
    }

    public function validateEditIncome($data)
    {
        $this->errors = [];

        if (empty($data['type'])) $this->errors['type'] = "Type is required";
        if (empty($data['name'])) $this->errors['name'] = "Name is required";
        if (empty($data['amount'])) $this->errors['amount'] = "Amount is required";
        if (empty($data['from'])) $this->errors['from'] = "From is required";
        if (empty($data['payment_type'])) $this->errors['payment_type'] = "Payment type is required";

        if ($data['amount'] < 0) {
            $this->errors['amount'] = "Amount is not valid";
        }

        if (empty($this->errors)) {
            return true;
        }

        return false;
    }

    public function validateAddExpense($data)
    {
        $this->errors = [];

        if (empty($data['club_id'])) $this->errors['club_id'] = "Club ID is required";
        if (empty($data['club_event_id'])) $this->errors['club_event_id'] = "Event ID is required";
        if (empty($data['type'])) $this->errors['type'] = "Type is required";
        if (empty($data['name'])) $this->errors['name'] = "Name is required";
        if (empty($data['amount'])) $this->errors['amount'] = "Amount is required";
        if (empty($data['from'])) $this->errors['from'] = "To is required";
        if (empty($data['payment_type'])) $this->errors['payment_type'] = "Payment type is required";

        if ($data['amount'] < 0) {
            $this->errors['amount'] = "Amount is not valid";
        }

        if (empty($this->errors)) {
            return true;
        }
        return false;
    }

    public function validateEditExpense($data)
    {
        $this->errors = [];

        if (empty($data['type'])) $this->errors['type'] = "Type is required";
        if (empty($data['name'])) $this->errors['name'] = "Name is required";
        if (empty($data['amount'])) $this->errors['amount'] = "Amount is required";
        if (empty($data['from'])) $this->errors['from'] = "To is required";
        if (empty($data['payment_type'])) $this->errors['payment_type'] = "Payment type is required";

        if ($data['amount'] < 0) {
            $this->errors['amount'] = "Amount is not valid";
        }

        if (empty($this->errors)) {
            return true;
        }

        return false;
    }    
}
