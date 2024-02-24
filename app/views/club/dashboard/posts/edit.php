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
                <span class="title">Edit Post</span>
            </div>
        </div>

        <div class="content-section">
            <form class="form" method="post" enctype="multipart/form-data">
                <?php $this->view('/includes/image-upload', ["name" => "image", "text" => "560x560"]) ?>

                <div class="form-section">
                    <p class="form-section-title">General Details</p>
                    <div class="form-section-content">
                        <input hidden value="<?= setValue('id') ?>" type="text" name="id" required>
                        <div class="input-wrap">
                            <label for="post_name">Post Name</label>
                            <input value="<?= setValue('post_name') ?>" id="post_name" type="text" name="post_name" placeholder="Post Name" required>
                            <?php if (!empty($errors['post_name'])) : ?>
                                <small>
                                    <?= $errors['post_name'] ?>
                                </small>
                            <?php endif; ?>
                        </div>

                        <div class="input-wrap">
                            <label for="description">Description</label>
                            <textarea id="description" name="description" placeholder="Description" required><?= setValue('description') ?></textarea>
                            <?php if (!empty($errors['description'])) : ?>
                                <small>
                                    <?= $errors['description'] ?>
                                </small>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="buttons-wrap">
                    <button type="submit" name="submit" value="edit-post" class="button contained">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </section>
</div>

<script src="<?= ROOT ?>/assets/js/form.js"></script>

<?php $this->view('includes/header/side-bars/club-dashboard', $menu_side_bar) ?>