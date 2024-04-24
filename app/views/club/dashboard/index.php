<head>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/side-bar.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/dashboard.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/club-dashboard.css">
</head>

<?php $this->view('includes/header') ?>

<!-- alerts -->
<?php $this->view('includes/alerts') ?>

<div id="club-dashboard-add-post" class="container container-sections side-padding club-dashboard dashboard-container">
    <?php $this->view('includes/side-bars/club/dashboard/left', $left_bar) ?>

    <section class="center-section">
        <div class="title-bar">
            <div class="title-wrap">
                <span class="title">Club Details</span>
            </div>
        </div>

        <div class="content-section">
            <form class="form" method="post" enctype="multipart/form-data">
                <?php if ($club_role == 'CLUB_IN_CHARGE') { ?>
                    <?php $this->view('/includes/image-upload', ["name" => "image", "text" => "560x560"]) ?>
                <?php } else {  ?>
                    <div class="image-upload">
                        <img data-show='true' src="<?= $club->image ?>" alt="Preview Image" class="preview-image">
                    </div>
                <?php } ?>

                <div class="form-section">
                    <p class="form-section-title">General Details</p>
                    <div class="form-section-content">
                        <div class="input-wrap">
                            <label for="name">Club Name</label>
                            <input <?php if ($club_role != 'CLUB_IN_CHARGE') { ?> readonly <?php } ?> value="<?= setValue('name') ?>" id="name" type="text" name="name" placeholder="Club Name" required>
                            <?php if (!empty($errors['name'])) : ?>
                                <small>
                                    <?= $errors['name'] ?>
                                </small>
                            <?php endif; ?>
                        </div>

                        <div class="input-wrap">
                            <label for="description">Description</label>
                            <textarea <?php if ($club_role != 'CLUB_IN_CHARGE') { ?> readonly <?php } ?> value id="description" name="description" placeholder="Description" required><?= setValue('description') ?></textarea>
                            <?php if (!empty($errors['description'])) : ?>
                                <small>
                                    <?= $errors['description'] ?>
                                </small>
                            <?php endif; ?>
                        </div>

                        <div class="input-wrap">
                            <label for="created_datetime">Create On</label>
                            <input readonly value="<?= $club->created_datetime ?>" id="created_datetime" type="datetime-local" name="created_datetime" placeholder="Created Date & Time" required>
                            <?php if (!empty($errors['created_datetime'])) : ?>
                                <small>
                                    <?= $errors['created_datetime'] ?>
                                </small>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <?php if ($club_role == 'CLUB_IN_CHARGE') { ?>
                    <div class="buttons-wrap">
                        <button type="submit" name="submit" value="update-club" class="button contained">
                            Update
                        </button>
                    </div>
                <?php } ?>
            </form>
        </div>
    </section>
</div>

<?php $this->view('includes/header/side-bars/club-dashboard', $menu_side_bar) ?>

<script src="<?= ROOT ?>/assets/js/form.js"></script>