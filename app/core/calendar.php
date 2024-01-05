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
    private $day;
    private $month_number;
    private $weeks = array();

    function __construct($year, $month, $day = 1)
    {
        if (!empty($year))
            $this->year = $year;
        if (!empty($month))
            $this->month_number = sprintf('%02d', $month);
        if (!empty($day))
            $this->day = $day;

        /* set timezone */
        $this->datetime = new DateTime();
        $timezone = new DateTimeZone('Asia/Colombo');
        $this->datetime->setTimezone($timezone);

        /* set date */
        $this->datetime->setDate($this->year, $this->month_number, $this->day);

        $this->setYearMonthDay();
    }

    private function setYearMonthDay()
    {
        $this->month = $this->datetime->format('F');
        $this->year = $this->datetime->format('Y');
        $this->day = $this->datetime->format('d');
    }

    private function setPrevNextMonths()
    {
        $this->prev_datetime = new DateTime($this->datetime->format('Y-m-d'));
        $this->prev_datetime->modify('-1month');

        $this->next_datetime = new DateTime($this->datetime->format('Y-m-d'));
        $this->next_datetime->modify('+1month');
    }

    private function setPrevNextDay()
    {
        $this->prev_datetime = new DateTime($this->datetime->format('Y-m-d'));
        $this->prev_datetime->modify('-1day');

        $this->next_datetime = new DateTime($this->datetime->format('Y-m-d'));
        $this->next_datetime->modify('+1day');
    }

    public function create()
    {
        $this->setYearMonthDay();
        $this->setPrevNextMonths();

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

        #fetch this month events
        $event = new Event();
        $events = $event->find([
            "state" => "ACTIVE",
            "start_datetime" => [
                "data" => $this->year . "-" . $this->month_number . "%",
                "operator" => "like"
            ]
        ], [], [], [
            "all" => true,
        ]);

        foreach ($this->weeks as &$week) {
            foreach ($week as &$item) {
                /* set events from db */
                $events_on_date =  array_filter($events, function ($event) use ($item) {
                    $moment = new \Moment\Moment($event->start_datetime);
                    $date = $moment->format('d');

                    return ((int) $date) == $item["day"];
                });

                $item["date_link"] = "year=" . $this->year . "&month=" . $this->month_number . "&day=" . $item["day"];
                $item["items"] = array_map(function ($record) {
                    return [
                        "name" => $record->name,
                        "date" => $record->start_datetime,
                        "start_time" => $record->start_datetime,
                        "location" => $record->venue
                    ];
                }, $events_on_date);
            }
        }

        return [
            "previous_params" => "&year=" . $this->prev_datetime->format('Y') . "&month=" . $this->prev_datetime->format('m'),
            "next_params" => "year=" . $this->next_datetime->format('Y') . "&month=" . $this->next_datetime->format('m'),
            "year" => $this->year,
            "month" => $this->month,
            "month_number" => $this->month_number,
            "weeks" => $this->weeks,
            "week_days" => $this->week_days,
            "week_days_short" => $this->week_days_short
        ];
    }

    public function createDay()
    {
        $this->setYearMonthDay();
        $this->setPrevNextDay();

        #fetch this month events
        $event = new Event();
        $events = $event->find([
            "state" => "ACTIVE",
            "start_datetime" => [
                "data" => $this->year . "-" . $this->month_number . "-" . $this->day . "%",
                "operator" => "like"
            ]
        ], [], [], [
            "all" => true,
            "order_column" => "start_datetime",
            "order" => "asc"
        ]);

        return [
            "previous_params" => "year=" . $this->prev_datetime->format('Y') . "&month=" . $this->prev_datetime->format('m') .  "&day=" . $this->prev_datetime->format('d'),
            "next_params" => "year=" . $this->next_datetime->format('Y') . "&month=" . $this->next_datetime->format('m') . "&day=" . $this->next_datetime->format('d'),
            "year" => $this->year,
            "month" => $this->month,
            "day" => $this->day,
            "month_number" => $this->month_number,
            "items" => $events
        ];
    }
}
