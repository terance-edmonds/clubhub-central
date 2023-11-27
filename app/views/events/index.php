<head>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/cards.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/events.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/side-bar.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/compact-calendar.css">
</head>

<?php $this->view('includes/header') ?>

<div id="events" class="container container-sections side-padding">
    <?php $this->view('includes/side-bars/events/left', $left_bar) ?>
    <section class="center-section">
        <div class="cards">
            <?php foreach($events as $event) { $this->view('includes/event-post', ["data" => $event]); } ?>
        </div>
    </section>
    <?php $this->view('includes/side-bars/events/right', $right_bar) ?>
</div>

<?php $this->view('includes/header/bottom') ?>