<head>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/register.css">
</head>

<!-- alerts -->
<?php $this->view('includes/alerts') ?>

<div id="register" class="full-container">
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
                <input value="<?= setValue('email') ?>" id="email" type="email" name="email" placeholder="Email Address" required>
                <?php if (!empty($errors['email'])) : ?>
                    <small><?= $errors['email'] ?></small>
                <?php endif; ?>
            </div>
            <div class="multi-wrap">
                <div class="input-wrap">
                    <label for="password">Password</label>
                    <input value="<?= setValue('password') ?>" id="password" type="password" name="password" placeholder="Password" required>
                    <?php if (!empty($errors['password'])) : ?>
                        <small><?= $errors['password'] ?></small>
                    <?php endif; ?>
                </div>
                <div class="input-wrap">
                    <label for="confirm_password">Confirm Password</label>
                    <input value="<?= setValue('confirm_password') ?>" id="confirm_password" type="password" name="confirm_password" placeholder="Confirm Password" required>
                    <?php if (!empty($errors['confirm_password'])) : ?>
                        <small><?= $errors['confirm_password'] ?></small>
                    <?php endif; ?>
                </div>
            </div>

            <button type="submit" class="button contained">Register</button>

            <div class="bottom-text">
                Already have an account? <a href="<?= ROOT ?>/login" class="cl-theme">Login here</a>
            </div>
        </form>
    </section>
</div>

<?php $this->view('includes/modals/register/confirm')  ?>

<script src="<?= ROOT ?>/assets/js/common.js"></script>
<script src="<?= ROOT ?>/assets/js/register.js"></script>
<script src="<?= ROOT ?>/assets/js/form.js"></script>