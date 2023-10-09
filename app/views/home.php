<head>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/cards.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/home.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/side-bar.css">
</head>

<?php $this->view('includes/header') ?>

<div id="home" class="container container-sections side-padding">
    <?php $this->view('includes/side-bars/events/left')  ?>
    <section class="center-section">
        <div class="cards">
            <?php $this->view('includes/club-post') ?>
        </div>
    </section>
    <?php $this->view('includes/side-bars/events/right')  ?>
</div>