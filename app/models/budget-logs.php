<?php

class BudgetLogs extends Modal
{
    protected $table = "club_event_budget_logs";
    protected $allowed_columns = [
        "club_id",
        "club_event_id",
        "club_event_budget_id",
        "club_member_id",
        "user_id",
        "type",
        "description"
    ];
}
