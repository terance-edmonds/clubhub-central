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
            <div class="input-wrap">
                <label for="email">Email Address</label>
                <input value="<?= setValue('email') ?>" id="email" type="email" name="email" placeholder="Email Address" required>
                <?php if (!empty($errors['email'])) : ?>
                    <small><?= $errors['email'] ?></small>
                <?php endif; ?>
            </div>
            <div class="input-wrap">
                <label for="password">Password</label>
                <input value="<?= setValue('password') ?>" id="password" type="password" name="password" placeholder="Password" required>
                <?php if (!empty($errors['password'])) : ?>
                    <small><?= $errors['password'] ?></small>
                <?php endif; ?>
            </div>
            <a href="/forgot-password" class="cl-theme f-14">Forgot Password?</a>

            <button class="button contained">Login</button>

            <div class="bottom-text">
                Don't have an account? <a href="<?= ROOT ?>/register" class="cl-theme">Register here</a>
            </div>
        </form>
    </section>
</div>

<script src="<?= ROOT ?>/assets/js/common.js"></script>