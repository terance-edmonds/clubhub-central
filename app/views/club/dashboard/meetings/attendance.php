<head>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/side-bar.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/dashboard.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/event-dashboard.css">
</head>

<?php $this->view('includes/header') ?>

<!-- alerts -->
<?php $this->view('includes/alerts') ?>

<div id="event-dashboard-registrations-attendance" class="container container-sections side-padding event-dashboard dashboard-container">
    <?php $this->view('includes/side-bars/club/dashboard/left', $left_bar) ?>

    <section class="center-section">
        <div class="title-bar">
            <div class="title-wrap">
                <span class="title">Mark Attendance</span>
            </div>
        </div>

        <?php if (!$user_found) { ?>
            <div class="qr-wrapper">
                <video id="preview"></video>
                <div class="message-wrap">
                    <p class="message">Please allow camera access</p>
                </div>

                <p class="note">
                    <span><b>Note: </b></span>
                    <span>Please scan the QR code sent to attendees email to mark attendance.</span>
                </p>
            </div>
        <?php } ?>


        <form class="form" method="post">
            <div class="input-wrap">
                <label for="id">Attendees' Invitation ID</label>
                <input readonly value="<?= setValue('id') ?>" name="id" id="id" type="text" placeholder="ID" required>
                <?php if (!empty($errors['id'])) : ?>
                    <small>
                        <?= $errors['id'] ?>
                    </small>
                <?php endif; ?>
            </div>

            <?php if ($user_found) { ?>
                <div class="input-wrap">
                    <label for="user_name">Full Name</label>
                    <input disabled value="<?= setValue('user_name') ?>" name="user_name" id="user_name" type="text" placeholder="Full Name" required>
                    <?php if (!empty($errors['user_name'])) : ?>
                        <small>
                            <?= $errors['user_name'] ?>
                        </small>
                    <?php endif; ?>
                </div>
                <div class="input-wrap">
                    <label for="user_email">Email Address</label>
                    <input disabled value="<?= setValue('user_email') ?>" name="user_email" id="user_email" type="email" placeholder="Email Address" required>
                    <?php if (!empty($errors['user_email'])) : ?>
                        <small>
                            <?= $errors['user_email'] ?>
                        </small>
                    <?php endif; ?>
                </div>
            <?php } ?>

            <?php if ($user_found) { ?>
                <button type="submit" name="submit" value="meeting-attendance-mark" class="button contained w-content">Mark as
                    Attended</button>
            <?php } else { ?>
                <button type="submit" name="submit" value="meeting-attendance-search" class="button contained w-content">Find
                    Details</button>
            <?php } ?>
        </form>
    </section>
</div>

<?php $this->view('includes/header/side-bars/club-dashboard', $menu_side_bar) ?>

<script src="<?= ROOT ?>/assets/js/form.js"></script>
<script src="<?= ROOT ?>/assets/js/libs/instascan.min.js"></script>
<script src="<?= ROOT ?>/assets/js/events/attendance.js"></script>