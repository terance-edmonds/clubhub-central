<?php foreach ($events as $event) {
        $this->view('includes/event-post', ["data" => $event]);
    }
