<?php

class ModCalendar
{
    private $week_days = array("Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun");
    private $week_days_short = array("Mo", "Tu", "We", "Th", "Fr", "Sa", "Su");
    private $datetime;
    private $prev_datetime;
    private $next_datetime;

    private $year;
    private $month;
    private $month_number;
    private $weeks = array();

    function __construct($year, $month)
    {
        if (!empty($year)) $this->year =  $year;
        if (!empty($month)) $this->month_number = $month;

        /* set timezone */
        $this->datetime = new DateTime();
        $timezone = new DateTimeZone('Asia/Colombo');
        $this->datetime->setTimezone($timezone);

        /* set date */
        $this->datetime->setDate($this->year, $this->month_number, 1);

        $this->setYearMonth();
    }

    private function setYearMonth()
    {
        $this->month = $this->datetime->format('F');
        $this->year = $this->datetime->format('Y');
    }

    private function setPrevNextDates()
    {
        $this->prev_datetime = new DateTime($this->datetime->format('Y-m-d'));
        $this->prev_datetime->modify('-1month');

        $this->next_datetime = new DateTime($this->datetime->format('Y-m-d'));
        $this->next_datetime->modify('+1month');
    }

    public function create()
    {
        $this->setYearMonth();
        $this->setPrevNextDates();

        $days_in_month = $this->datetime->format('t');
        $day_month_starts = $this->datetime->format('N');

        $days = array_fill(0, ($day_month_starts - 1), [
            "day" => ''
        ]);

        for ($i = 1; $i <= $days_in_month; $i++) {
            $days[] = [
                "day" => $i
            ];
        }

        while (count($days) % 7 != 0) {
            $days[] = [
                "day" => ''
            ];
        }

        $this->weeks = array_chunk($days, 7);

        foreach ($this->weeks as &$week) {
            foreach ($week as &$item) {
                if ($item["day"] == 1) {
                    $item["items"] = [
                        [
                            "name" => "Fresher's Day",
                            "date" => "11/10/2023",
                            "start_time" => "10.00 A.M",
                            "location" => "UCSC Grounds"
                        ]
                    ];
                }
            }
        }

        return [
            "previous_params" => "month=" . $this->prev_datetime->format('m') . "&year=" . $this->prev_datetime->format('Y'),
            "next_params" => "month=" . $this->next_datetime->format('m') . "&year=" . $this->next_datetime->format('Y'),
            "year" => $this->year,
            "month" => $this->month,
            "month_number" => $this->month_number,
            "weeks" => $this->weeks,
            "week_days" => $this->week_days,
            "week_days_short" => $this->week_days_short
        ];
    }
}
