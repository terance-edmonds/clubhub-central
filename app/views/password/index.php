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
            <h1>Forgot Password</h1>
            <p class="desc">Please enter your email address. You will receive a link to create a new password.</p>
            <div class="input-wrap">
                <label for="email">Email Address</label>
                <input value="<?= setValue('email') ?>" id="email" type="email" name="email" placeholder="Email Address" required>
                <?php if (!empty($errors['email'])) : ?>
                    <small><?= $errors['email'] ?></small>
                <?php endif; ?>
            </div>

            <button type="submit" class="button contained">Request Reset Link</button>

            <div class="bottom-text">
                Already have an account? <a href="<?= ROOT ?>/login" class="cl-theme">Login here</a>
            </div>
        </form>
    </section>
</div>

<script src="<?= ROOT ?>/assets/js/common.js"></script>
<script src="<?= ROOT ?>/assets/js/form.js"></script>