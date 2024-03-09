<head>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/login.css">
</head>

<!-- alerts -->
<?php $this->view('includes/alerts') ?>

<div id="login" class="full-container">
    <section class="section left">
        <div class="content">
            <span class="title">
                The Perfect Event Every Time!
            </span>
            <span class="sub-title">WITH <span class="cl-theme">CLUB CENTRAL</span>
        </div>
    </section>
    <section class="section right">
        <form class="form" method="post">
            <h1>Reset Password</h1>
            <p class="desc">Strong passwords include numbers, letters, and punctuation marks.</p>

            <div class="input-wrap">
                <label for="new_password">New Password</label>
                <input value="<?= setValue('new_password') ?>" id="new_password" type="password" name="new_password" placeholder="New Password" required>
                <?php if (!empty($errors['new_password'])) : ?>
                    <small>
                        <?= $errors['new_password'] ?>
                    </small>
                <?php endif; ?>
            </div>
            <div class="input-wrap">
                <label for="confirm_new_password">Confirm New Password</label>
                <input value="<?= setValue('confirm_new_password') ?>" id="confirm_new_password" type="password" name="confirm_new_password" placeholder="Confirm New Password" required>
                <?php if (!empty($errors['confirm_new_password'])) : ?>
                    <small>
                        <?= $errors['confirm_new_password'] ?>
                    </small>
                <?php endif; ?>
            </div>

            <button type="submit" class="button contained">Reset Password</button>

            <div class="bottom-text">
                Already have an account? <a href="<?= ROOT ?>/login" class="cl-theme">Login here</a>
            </div>
        </form>
    </section>
</div>

<script src="<?= ROOT ?>/assets/js/common.js"></script>
<script src="<?= ROOT ?>/assets/js/form.js"></script>