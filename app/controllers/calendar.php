<?php

class Calendar extends Controller
{
    public function index()
    {
    }

    public function date()
    {
        $this->view("calendar/date");
    }
}
