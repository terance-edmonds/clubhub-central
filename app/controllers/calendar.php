<?php

class Calendar extends Controller
{
    private $week_days = array("Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun");
    private $datetime;
    private $prev_datetime;
    private $next_datetime;

    private $year;
    private $month;
    private $month_number;
    private $weeks = array();

    function __construct()
    {
        $this->datetime = new DateTime();
        $this->setYearMonth($this->datetime);
    }

    private function create()
    {
        $date = $this->datetime->setDate($this->year, $this->month_number, 1);
        $this->setYearMonth($this->datetime);
        $this->setPrevNextDates($date->format('Y-m-d'));

        $days_in_month = $date->format('t');
        $day_month_starts = $date->format('N');

        $days = array_fill(0, ($day_month_starts - 1), '');

        for ($i = 1; $i <= $days_in_month; $i++) {
            $days[] = $i;
        }

        while (count($days) % 7 != 0) {
            $days[] = '';
        }

        $this->weeks = array_chunk($days, 7);
    }

    private function setYearMonth($date)
    {
        $this->month = $date->format('F');
        $this->year = $date->format('Y');
    }

    private function setPrevNextDates($date)
    {
        $this->prev_datetime = new DateTime($date);
        $this->prev_datetime->modify('-1month');

        $this->next_datetime = new DateTime($date);
        $this->next_datetime->modify('+1month');
    }

    public function index()
    {
        $this->year = $this->datetime->format('Y');
        $this->month_number = $this->datetime->format('m');

        /* set year and month */
        if (!empty($_GET['month'])) $this->month_number = (int) $_GET['month'];
        if (!empty($_GET['year'])) $this->year = (int) $_GET['year'];

        $this->create();

        $data = [
            "previous_params" => "month=" . $this->prev_datetime->format('m') . "&year=" . $this->prev_datetime->format('Y'),
            "next_params" => "month=" . $this->next_datetime->format('m') . "&year=" . $this->next_datetime->format('Y'),
            "year" => $this->year,
            "month" => $this->month,
            "month_number" => $this->month_number,
            "weeks" => $this->weeks,
            "week_days" => $this->week_days
        ];

        $this->view("calendar", $data);
    }
}
