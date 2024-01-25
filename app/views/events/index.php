<head>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/cards.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/events.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/side-bar.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/compact-calendar.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/scroll-loader.css">
</head>

<?php $this->view('includes/header') ?>

<div id="events" class="container container-sections side-padding">
    <?php $this->view('includes/side-bars/events/left', $left_bar) ?>
    <section class="center-section">
        <div id="event-cards" class="cards">
            <?php foreach ($events as $event) {
                $this->view('includes/event-post', ["data" => $event]);
            } ?>
        </div>

        <?php $this->view('includes/scroll-loader') ?>
    </section>
    <?php $this->view('includes/side-bars/events/right', $right_bar) ?>
</div>

<?php $this->view('includes/header/side-bars/home', $menu_side_bar) ?>

<?php $this->view('includes/header/bottom') ?>

<script src="<?= ROOT ?>/assets/js/events/events.js"></script>