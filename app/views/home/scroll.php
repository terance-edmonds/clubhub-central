<?php foreach ($posts as $post) {
    $this->view('includes/club-post', ["data" => $post]);
}
