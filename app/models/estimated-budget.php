<?php

class EstimatedBudget extends Modal
{
    protected $table = "club_event_estimated_budgets";
    protected $allowed_columns = [
        "club_id",
        "club_event_id",
        "type",
        "name",
        "description",
        "amount",
        "third_party",
        "payment_type",
        "is_deleted"
    ];
    protected $search_columns = [
        "name",
        "description",
    ];

    public function validateAddIncome($data)
    {
        $this->errors = [];

        if (empty($data['club_id'])) $this->errors['club_id'] = "Club ID is required";
        if (empty($data['club_event_id'])) $this->errors['club_event_id'] = "Event ID is required";
        if (empty($data['type'])) $this->errors['type'] = "Type is required";
        if (empty($data['name'])) $this->errors['name'] = "Name is required";
        if (empty($data['amount'])) $this->errors['amount'] = "Amount is required";
        if (empty($data['third_party'])) $this->errors['third_party'] = "From is required";
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
        if (empty($data['third_party'])) $this->errors['third_party'] = "From is required";
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
        if (empty($data['third_party'])) $this->errors['third_party'] = "To is required";
        if (empty($data['payment_type'])) $this->errors['payment_type'] = "Payment type is required";

        if ($data['amount'] < 0) {
            $this->errors['amount'] = "Amount is not valid";
        }

        $income_data = $this->find(["club_id" => $data['club_id'], "club_event_id" => $data['club_event_id'], "is_deleted" => 0, "type" => "INCOME"], ["sum(amount) as total"]);
        $expense_data = $this->find(["club_id" => $data['club_id'], "club_event_id" => $data['club_event_id'], "is_deleted" => 0, "type" => "EXPENSE"], ["sum(amount) as total"]);

        $total_income = $income_data[0]->total ? $income_data[0]->total :  0;
        $total_expense = $expense_data[0]->total ? $expense_data[0]->total : 0;

        $total_expense += (float) $data['amount'];
        if ($total_expense > $total_income) {
            $this->errors['amount'] = "Total expenses must be less than the total income";
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
        if (empty($data['third_party'])) $this->errors['third_party'] = "To is required";
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
