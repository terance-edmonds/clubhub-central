<?php

class Calendar extends Controller
{
    public function index()
    {
        $datetime = new DateTime();
        $year = $datetime->format('Y');
        $month_number = $datetime->format('m');

        /* set year and month */
        if (!empty($_GET['month'])) $month_number = (int) $_GET['month'];
        if (!empty($_GET['year'])) $year = (int) $_GET['year'];

        $calendar = new ModCalendar($year, $month_number);
        $data = $calendar->create();

        $this->view("calendar", $data);
    }

    public function date()
    {
        $datetime = new DateTime();
        $year = $datetime->format('Y');
        $month_number = $datetime->format('m');
        $day = $datetime->format('d');

        /* set year and month */
        if (!empty($_GET['month'])) $month_number = (int) $_GET['month'];
        if (!empty($_GET['year'])) $year = (int) $_GET['year'];
        if (!empty($_GET['day'])) $day = (int) $_GET['day'];

        $calendar = new ModCalendar($year, $month_number, $day);
        $data = $calendar->createDay();

        $this->view("calendar/date", $data);
    }
}
