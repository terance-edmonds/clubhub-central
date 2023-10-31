<head>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/side-bar.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/dashboard.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/club-dashboard.css">
</head>

<?php $this->view('includes/header') ?>

<div id="club-dashboard-event" class="container container-sections side-padding club-dashboard dashboard-container">
    <?php $this->view('includes/side-bars/club/dashboard/left', ["menu" => $menu])  ?>