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

        foreach ($data["weeks"] as &$week) {
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

        $this->view("calendar", $data);
    }
}
