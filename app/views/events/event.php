<head>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/event.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/side-bar.css">
</head>

<?php $this->view('includes/header') ?>

<div id="event" class="container container-sections side-padding">

    <section class="center-section">
        <img loading="lazy" src="<?= $event_data['image'] ?>" alt="Event Cover" class="club-event-image">

        <div class="content">
            <div class="title-wrap">
                <span class="title f-24"><?= $event_data['name'] ?></span>

                <?php if ($event_data['open_registrations']) { ?>
                    <button onclick="$(`[popup-name='event-register']`).popup(true)" class="button contained">Register Now</button>
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
                        <span><?= $event_data['start_date'] ?></span>
                        <span><?= $event_data['start_time'] ?></span>
                    </div>
                </div>
                <div class="detail-wrap">
                    <div class="icon">
                        <span class="material-icons-outlined">
                            fmd_good
                        </span>
                    </div>
                    <div class="texts">
                        <span><?= $event_data['venue'] ?></span>
                    </div>
                </div>
            </div>

            <p class="description"><?= $event_data['description'] ?></p>
        </div>
    </section>

    <?php $this->view('includes/side-bars/events/right')  ?>
</div>

<?php $this->view('includes/modals/event/register') ?>