<?php

class Events extends Controller
{
    public function index()
    {
        $this->view("events");
    }

    public function event()
    {
        $this->view("events/event");
    }
}
