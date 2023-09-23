<?php

class NotFound extends Controller
{
    public function index()
    {
        $data['title'] = '404';

        $this->view("not-found", $data);
    }
}
