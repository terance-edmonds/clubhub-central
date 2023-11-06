<head>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/dashboard.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/edit-profile.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/side-bar.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/compact-calendar.css">
</head>


<?php $this->view('includes/header') ?>

<!-- alerts -->
<?php $this->view('includes/alerts') ?>

<div id="profile-edit" class="container container-sections side-padding dashboard-container">
    <?php $this->view('includes/side-bars/profile/left', $left_bar)  ?>
    <section class="center-section">
        <div class="title-bar set-padding">
            <div class="title-wrap">
                <span class="title">Event Details</span>

            </div>
        </div>

        <div class="content-section">
            <form class="form" method="post" enctype="multipart/form-data">
                <?php $this->view('/includes/image-upload', ["name" => "image"]) ?>

                <div class="form-section">
                    <p class="form-section-title">General Details</p>
                    <div class="form-section-content">
                        <div class="multi-wrap">
                            <div class="input-wrap">
                                <label for="first_name">First Name</label>
                                <input value="<?= setValue('first_name') ?>" id="first_name" type="text" name="first_name" placeholder="First Name" required>
                                <?php if (!empty($errors['first_name'])) : ?>
                                    <small><?= $errors['first_name'] ?></small>
                                <?php endif; ?>
                            </div>
                            <div class="input-wrap">
                                <label for="last_name">Last Name</label>
                                <input value="<?= setValue('last_name') ?>" id="last_name" type="text" name="last_name" placeholder="Last Name" required>
                                <?php if (!empty($errors['last_name'])) : ?>
                                    <small><?= $errors['last_name'] ?></small>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="input-wrap">
                            <label for="email">Email Address</label>
                            <input disabled value="<?= setValue('email') ?>" id="email" type="email" name="email" placeholder="Email Address">
                            <?php if (!empty($errors['email'])) : ?>
                                <small><?= $errors['email'] ?></small>
                            <?php endif; ?>
                        </div>

                        <div class="input-wrap">
                            <label for="description">Description</label>
                            <textarea id="description" name="description" placeholder="Description"><?= setValue('description') ?></textarea>
                            <?php if (!empty($errors['description'])) : ?>
                                <small><?= $errors['description'] ?></small>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="buttons-wrap">
                    <button type="submit" name="submit" value="update_profile" class="button contained">Save Details</button>
                </div>
            </form>

            <form name="change_password" class="form" method="post">
                <div class="form-section">
                    <p class="form-section-title">Change Password</p>
                    <div class="form-section-content">
                        <div class="input-wrap">
                            <label for="current_password">Current Password</label>
                            <input value="<?= setValue('current_password') ?>" id="current_password" type="password" name="current_password" placeholder="Current Password" required>
                            <?php if (!empty($errors['current_password'])) : ?>
                                <small><?= $errors['current_password'] ?></small>
                            <?php endif; ?>
                        </div>

                        <div class="multi-wrap">
                            <div class="input-wrap">
                                <label for="new_password">New Password</label>
                                <input value="<?= setValue('new_password') ?>" id="new_password" type="password" name="new_password" placeholder="New Password" required>
                                <?php if (!empty($errors['new_password'])) : ?>
                                    <small><?= $errors['new_password'] ?></small>
                                <?php endif; ?>
                            </div>
                            <div class="input-wrap">
                                <label for="confirm_new_password">Confirm New Password</label>
                                <input value="<?= setValue('confirm_new_password') ?>" id="confirm_new_password" type="password" name="confirm_new_password" placeholder="Confirm New Password" required>
                                <?php if (!empty($errors['confirm_new_password'])) : ?>
                                    <small><?= $errors['confirm_new_password'] ?></small>
                                <?php endif; ?>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="buttons-wrap">
                    <button type="submit" name="submit" value="change_password" class="button contained">Change Password</button>
                </div>
            </form>
        </div>
    </section>
</div>

<script src="<?= ROOT ?>/assets/js/common.js"></script>
<script src="<?= ROOT ?>/assets/js/form.js"></script>