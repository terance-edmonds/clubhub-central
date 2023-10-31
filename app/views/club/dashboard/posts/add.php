<head>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/side-bar.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/dashboard.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/club-dashboard.css">
</head>

<?php $this->view('includes/header') ?>

<div id="club-dashboard-add-post" class="container container-sections side-padding club-dashboard dashboard-container">
    <?php $this->view('includes/side-bars/club/dashboard/left', ["menu" => $menu])  ?>

    <section class="center-section">
        <div class="title-bar">
            <div class="title-wrap">
                <span class="title">New Post</span>
            </div>
        </div>

        <div class="content-section">
            <form class="form" method="post" enctype="multipart/form-data">
                <?php $this->view('/includes/image-upload', ["name" => "image", "text" => "560x560"]) ?>

                <div class="form-section">
                    <p class="form-section-title">General Details</p>
                    <div class="form-section-content">
                        <div class="input-wrap">
                            <label for="name">Post Name</label>
                            <input value="<?= setValue('name') ?>" id="name" type="text" name="name" placeholder="First Name" required>
                            <?php if (!empty($errors['name'])) : ?>
                                <small><?= $errors['name'] ?></small>
                            <?php endif; ?>
                        </div>

                        <div class="input-wrap">
                            <label for="description">Description</label>
                            <textarea value="<?= setValue('description') ?>" id="description" name="description" placeholder="Description" required></textarea>
                            <?php if (!empty($errors['description'])) : ?>
                                <small><?= $errors['description'] ?></small>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="buttons-wrap">
                    <button name="submit" value="update_profile" class="button contained">Create Post</button>
                </div>
            </form>
        </div>
    </section>
</div>