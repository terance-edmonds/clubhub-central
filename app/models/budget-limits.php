<?php

class BudgetLimits extends Modal
{
    protected $table = "club_event_budget_limits";
    protected $allowed_columns = [
        "club_id",
        "club_event_id",
        "name",
        "amount",
        "description"
    ];

    public function validateAddBudget($data)
    {
        $this->errors = [];

        if (empty($data['name'])) $this->errors['name'] = "Name is required";
        if (empty($data['amount'])) $this->errors['amount'] = "Amount is required";

        if ($data['amount'] < 0) {
            $this->errors['amount'] = "Amount is not valid";
        }

        if (empty($this->errors)) {
            return true;
        }
        return false;
    }
}
