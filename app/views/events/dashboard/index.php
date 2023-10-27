<head>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/side-bar.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/event-dashboard.css">
</head>

<?php $this->view('includes/header') ?>

<div id="event-dashboard-event" class="container container-sections side-padding event-dashboard dashboard-container">
    <?php $this->view('includes/side-bars/events/dashboard/left', $menu_data)  ?>

    <section class="center-section">
        <div class="title-bar">
            <div class="title-wrap">
                <span class="title">Event Details</span>

            </div>
        </div>

        <div class="content-section">
            event details
        </div>

    </section>
</div>

<?php $this->view('includes/modals/event/register')  ?>
<script src="<?= ROOT ?>/assets/js/events/event.js"></script>