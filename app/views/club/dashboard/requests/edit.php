<head>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/side-bar.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/dashboard.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/club-dashboard.css">
</head>

<?php $this->view('includes/header') ?>

<?php $this->view('includes/alerts') ?>

<div id="club-dashboard-add-request" class="container container-sections side-padding club-dashboard dashboard-container">
    <?php $this->view('includes/side-bars/club/dashboard/left', $left_bar) ?>

    <section class="center-section">
        <div class="title-bar">
            <div class="title-wrap">
                <span class="title">Update Request</span>
            </div>
        </div>

        <div class="content-section">
            <form class="form" method="post">
                <div class="form-section">
                    <p class="form-section-title">Details</p>
                    <div class="form-section-content">
                        <div class="multi-wrap">
                            <div class="input-wrap">
                                <label for="event">Choose Event</label>
                                <select name="club_event_id" id="event" required>
                                    <option value="" selected disabled hidden>Choose Event</option>
                                    <?php foreach ($event_data as $event) { ?>
                                        <option <?php if ($event->id == setValue('club_event_id')) { ?> selected <?php } ?> value="<?= $event->id ?>"><?= displayValue($event->name) ?></option>
                                    <?php } ?>
                                </select>
                                <?php if (!empty($errors['event'])) : ?>
                                    <small>
                                        <?= $errors['event'] ?>
                                    </small>
                                <?php endif; ?>
                            </div>
                            <div class="input-wrap">
                                <label for="subject">Request Subject</label>
                                <input value="<?= setValue('subject') ?>" id="subject" type="text" name="subject" placeholder="Request Subject" required>
                                <?php if (!empty($errors['subject'])) : ?>
                                    <small>
                                        <?= $errors['subject'] ?>
                                    </small>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="input-wrap">
                            <label for="description">Description</label>
                            <textarea id="description" name="description" placeholder="Description" required><?= setValue('description') ?></textarea>
                            <?php if (!empty($errors['description'])) : ?>
                                <small>
                                    <?= $errors['description'] ?>
                                </small>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="buttons-wrap">
                    <button type="submit" name="submit" value="update-request" class="button contained">Update Request</button>
                </div>
            </form>
        </div>
    </section>
</div>

<?php $this->view('includes/modals/event/register') ?>
<?php $this->view('includes/header/side-bars/club-dashboard', $menu_side_bar) ?>

<script src="<?= ROOT ?>/assets/js/events/event.js"></script>
<script src="<?= ROOT ?>/assets/js/form.js"></script>