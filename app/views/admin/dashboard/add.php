<head>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/side-bar.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/dashboard.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/club-dashboard.css">
</head>

<?php $this->view('includes/header') ?>

<!-- alerts -->
<?php $this->view('includes/alerts') ?>

<div id="admin-dashboard-add-club" class="container container-sections side-padding club-dashboard dashboard-container">
    <?php $this->view('includes/side-bars/club/dashboard/left', ["menu" => $menu])  ?>

    <section class="center-section">
        <div class="title-bar">
            <div class="title-wrap">
                <span class="title">Create A New Club</span>
            </div>
        </div>

        <div class="content-section">
            <form class="form" method="post">
                <div class="form-section">
                    <p class="form-section-title">General Details</p>
                    <div class="form-section-content">
                        <div class="multi-wrap">
                            <div class="input-wrap">
                                <label for="name">Club Name</label>
                                <input value="<?= setValue('name') ?>" id="name" type="text" name="name" placeholder="Club Name" required>
                                <?php if (!empty($errors['name'])) : ?>
                                    <small><?= $errors['name'] ?></small>
                                <?php endif; ?>
                            </div>
                            <div class="input-wrap">
                                <label for="club_in_charge_email">Club In-charge Email</label>
                                <input value="<?= setValue('club_in_charge_email') ?>" id="club_in_charge_email" type="email" name="club_in_charge_email" placeholder="Club In-charge Email" required>
                                <?php if (!empty($errors['club_in_charge_email'])) : ?>
                                    <small><?= $errors['club_in_charge_email'] ?></small>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="buttons-wrap">
                    <button class="button contained">Create Club</button>
                </div>
            </form>
        </div>
    </section>
</div>