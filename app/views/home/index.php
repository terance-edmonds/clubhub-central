<head>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/cards.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/home.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/side-bar.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/compact-calendar.css">
</head>

<?php $this->view('includes/header') ?>

<div id="home" class="container container-sections side-padding">
    <?php $this->view('includes/side-bars/events/left', $left_bar) ?>
    <section class="center-section">
        <div class="cards">
            <?php
            if (count($posts) == 0) {
                echo "No Club Posts Found.";
            } else {
                foreach ($posts as $post) {
                    $this->view('includes/club-post', ["data" => $post]);
                }
            }
            ?>
        </div>

        <?php $this->view('includes/scroll-loader') ?>
    </section>
    <?php $this->view('includes/side-bars/events/right', $right_bar) ?>
</div>

<?php $this->view('includes/header/side-bars/home', $menu_side_bar) ?>

<?php $this->view('includes/header/bottom') ?>

<script src="<?= ROOT ?>/assets/js/home.js"></script>
<script src="<?= ROOT ?>/assets/js/cards.js"></script>