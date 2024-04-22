<head>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/side-bar.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/dashboard.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/club-dashboard.css">
</head>

<?php $this->view('includes/header') ?>

<div id="club-dashboard-add-report" class="container container-sections side-padding club-dashboard dashboard-container">
    <?php $this->view('includes/side-bars/club/dashboard/left', $left_bar) ?>

    <section class="center-section">
        <div class="title-bar">
            <div class="title-wrap">
                <span class="title">New Report</span>
            </div>
        </div>

        <div class="content-section">
            <form class="form bottom-border" method="post" onsubmit="onSubmit(event)">
                <input type="text" name="report_type" value="Event Details" hidden>
                <div class="form-section no-border">
                    <p class="form-section-title">Event Details Report</p>
                    <div class="form-section-content">
                        <?php if (!empty($errors['errors'])) : ?>
                            <small>
                                <?= $errors['errors'] ?>
                            </small>
                        <?php endif; ?>

                        <div class="multi-wrap">
                            <div class="input-wrap">
                                <label>Report Name</label>
                                <input value="<?= setValue('report_name') ?>" type="text" name="report_name" placeholder="Report Name" required>
                                <?php if (!empty($errors['report_name'])) : ?>
                                    <small>
                                        <?= $errors['report_name'] ?>
                                    </small>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="multi-wrap">
                            <div class="input-wrap">
                                <label>Start Date</label>
                                <input id="events_datetime_start" set-min set-default="date" value="<?= setValue('start_datetime') ?>" type="date" name="start_datetime" placeholder="Start Date" required>
                                <?php if (!empty($errors['start_datetime'])) : ?>
                                    <small>
                                        <?= $errors['start_datetime'] ?>
                                    </small>
                                <?php endif; ?>
                            </div>
                            <div class="input-wrap">
                                <label>End Date</label>
                                <input id="events_datetime_end" set-min set-default="date" value="<?= setValue('end_datetime') ?>" type="date" name="end_datetime" placeholder="End Date" required>
                                <?php if (!empty($errors['end_datetime'])) : ?>
                                    <small>
                                        <?= $errors['end_datetime'] ?>
                                    </small>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="buttons-wrap">
                    <button type="submit" name="submit" value="generate-report" class="button contained">Generate</button>
                </div>
            </form>

            <form class="form bottom-border" method="post" onsubmit="onSubmit(event)">
                <input type="text" name="report_type" value="Member Details" hidden>
                <div class="form-section no-border">
                    <p class="form-section-title">User Details Report</p>
                    <div class="form-section-content">
                        <?php if (!empty($errors['errors'])) : ?>
                            <small>
                                <?= $errors['errors'] ?>
                            </small>
                        <?php endif; ?>

                        <div class="multi-wrap">
                            <div class="input-wrap">
                                <label>Report Name</label>
                                <input value="<?= setValue('report_name') ?>" type="text" name="report_name" placeholder="Report Name" required>
                                <?php if (!empty($errors['report_name'])) : ?>
                                    <small>
                                        <?= $errors['report_name'] ?>
                                    </small>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="multi-wrap">
                            <div class="input-wrap">
                                <label>Start Date</label>
                                <input id="users_datetime_start" set-default="date" value="<?= setValue('start_datetime') ?>" type="date" name="start_datetime" placeholder="Start Date" required>
                                <?php if (!empty($errors['start_datetime'])) : ?>
                                    <small>
                                        <?= $errors['start_datetime'] ?>
                                    </small>
                                <?php endif; ?>
                            </div>
                            <div class="input-wrap">
                                <label>End Date</label>
                                <input id="users_datetime_end" set-default="date" value="<?= setValue('end_datetime') ?>" type="date" name="end_datetime" placeholder="End Date" required>
                                <?php if (!empty($errors['end_datetime'])) : ?>
                                    <small>
                                        <?= $errors['end_datetime'] ?>
                                    </small>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="buttons-wrap">
                    <button type="submit" name="submit" value="generate-report" class="button contained">Generate</button>
                </div>
            </form>
        </div>
    </section>
</div>

<?php $this->view('includes/header/side-bars/club-dashboard', $menu_side_bar) ?>

<script src="<?= ROOT ?>/assets/js/form.js"></script>
<script src="<?= ROOT ?>/assets/js/club/dashboard/reports.js"></script>