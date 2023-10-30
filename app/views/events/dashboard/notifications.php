<head>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/side-bar.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/dashboard.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/event-dashboard.css">
</head>

<?php $this->view('includes/header') ?>

<!-- alerts -->
<?php $this->view('includes/alerts') ?>

<div id="event-dashboard-registrations" class="container container-sections side-padding event-dashboard dashboard-container">
    <?php $this->view('includes/side-bars/events/dashboard/left', ["menu" => $menu])  ?>

    <section class="center-section">
        <div class="title-bar">
            <div class="title-wrap">
                <span class="title">Notifications</span>
            </div>
        </div>

        <div class="content-section">
            <form class="form" method="post">
                <div class="form-section">
                    <p class="form-section-title">General Details</p>
                    <div class="form-section-content">
                        <div class="input-wrap">
                            <label for="to">To</label>
                            <input value="<?= setValue('to') ?>" id="to" type="text" name="to" placeholder="example@example.com, example1@example.com" required>
                            <?php if (!empty($errors['to'])) : ?>
                                <small><?= $errors['to'] ?></small>
                            <?php endif; ?>
                        </div>
                        <div class="input-wrap">
                            <label for="subject">Subject</label>
                            <input value="<?= setValue('subject') ?>" id="subject" type="text" name="subject" placeholder="Subject" required>
                            <?php if (!empty($errors['subject'])) : ?>
                                <small><?= $errors['subject'] ?></small>
                            <?php endif; ?>
                        </div>
                        <div class="input-wrap">
                            <label for="description">Description</label>
                            <textarea id="description" type="text" name="description" placeholder="Description" required><?= setValue('description') ?></textarea>
                            <?php if (!empty($errors['description'])) : ?>
                                <small><?= $errors['description'] ?></small>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="buttons-wrap">
                    <button name="submit" value="update_profile" class="button contained">Send Email</button>
                </div>
            </form>
        </div>
    </section>
</div>

<script src="<?= ROOT ?>/assets/js/events/event.js"></script>