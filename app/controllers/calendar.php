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
}
