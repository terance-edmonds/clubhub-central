<head>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/side-bar.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/dashboard.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/event-dashboard.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/event.css">
</head>

<?php $this->view('includes/header') ?>

<?php $this->view('includes/alerts') ?>

<div id="event-dashboard-event-edit" class="container container-sections side-padding event-dashboard dashboard-container">
    <?php $this->view('includes/side-bars/events/dashboard/left', $left_bar) ?>

    <section class="center-section no-padding">
        <div class="title-bar set-padding">
            <div class="title-wrap">
                <span class="title">Event Preview</span>
            </div>
        </div>

        <div id="event" class="side-padding">

            <section class="center-section">
                <img loading="lazy" src="<?= $event_data['image'] ?>" alt="Event Cover" class="club-event-image">

                <div class="content">
                    <div class="title-wrap">
                        <span class="title f-24">
                            <?= $event_data['name'] ?>
                        </span>

                        <?php if ($event_data['open_registrations']) { ?>
                            <button class="button contained">Register
                                Now</button>
                        <?php } ?>
                    </div>

                    <div class="details-wrap">
                        <div class="detail-wrap">
                            <div class="icon">
                                <span class="material-icons-outlined">
                                    calendar_month
                                </span>
                            </div>
                            <div class="texts">
                                <span>
                                    <?= $event_data['start_date'] ?>
                                </span>
                                <span>
                                    <?= $event_data['start_time'] ?>
                                </span>
                            </div>
                        </div>
                        <div class="detail-wrap">
                            <div class="icon">
                                <span class="material-icons-outlined">
                                    fmd_good
                                </span>
                            </div>
                            <div class="texts">
                                <span>
                                    <?= $event_data['venue'] ?>
                                </span>
                            </div>
                        </div>
                    </div>

                    <p class="description">
                        <?= $event_data['description'] ?>
                    </p>
                </div>
            </section>
        </div>
    </section>
</div>

<script src="<?= ROOT ?>/assets/js/events/edit-event.js"></script>
<script src="<?= ROOT ?>/assets/js/form.js"></script>

<?php $this->view('includes/header/side-bars/event-dashboard', $menu_side_bar) ?>