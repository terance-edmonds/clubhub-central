<head>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/event.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/side-bar.css">
</head>

<?php $this->view('includes/header') ?>

<?php $this->view('includes/alerts') ?>

<div id="event" class="container container-sections side-padding">

    <section class="center-section">
        <img loading="lazy" src="<?= $event_data['image'] ?>" alt="Event Cover" class="club-event-image">

        <div class="content">
            <div class="title-wrap">
                <span class="title f-24">
                    <?= $event_data['name'] ?>
                </span>

                <?php if ($event_data['state'] == 'ACTIVE' && $event_data['open_registrations']) { ?>
                    <button onclick="$(`[popup-name='event-register']`).popup(true)" class="button contained">Register
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

            <p class="description"><?= $event_data['description'] ?></p>

            <?php if ($event_data['state'] != 'DEACTIVE') { ?>
                <div class="complain-note">
                    <span>If you have any complaints, please use the button below to fill out the form. Your feedback will help us improve our future events.</span>
                    <button onclick="$(`[popup-name='add-complain']`).popup(true)" class=" button w-content contained">Complains</button>
                </div>
            <?php } ?>
        </div>
    </section>

    <?php $this->view('includes/side-bars/events/right', $right_bar) ?>
</div>

<?php if ($event_data['state'] != 'DEACTIVE') $this->view('includes/modals/event/complain'); ?>

<?php if ($event_data['state'] == 'ACTIVE' && $event_data['open_registrations']) $this->view('includes/modals/event/register', ["errors" => $errors]); ?>

<script>
    <?php if (!empty($popups["event-register"])) { ?>
        $(`[popup-name='event-register']`).popup(true)
    <?php } ?>
</script>

<?php $this->view('includes/header/bottom') ?>

<script src="<?= ROOT ?>/assets/js/form.js"></script>