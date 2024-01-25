<head>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/cards.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/profile.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/side-bar.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/compact-calendar.css">
</head>

<?php $this->view('includes/header') ?>

<div id="profile" class="container container-sections side-padding">
    <?php $this->view('includes/side-bars/profile/left', $left_bar) ?>
    <section class="center-section">
        <div class="tabs">
            <a href="<?= ROOT ?>/profile" class="tab" data-active="<?php if ($tab == 'gallery')
                                                                        echo 'true'; ?>"><span class="text">Gallery</span></a>
            <a href="<?= ROOT ?>/profile?tab=club-posts" class="tab" data-active="<?php if ($tab == 'club-posts')
                                                                                        echo 'true'; ?>"><span class="text">Club Posts</span></a>
        </div>
        <?php if ($tab == 'club-posts') { ?>
            <div class="cards">
                <?php $this->view('includes/club-post') ?>
            </div>
        <?php } else { ?>
            <div class="gallery">
                <?php foreach ($gallery as $item) { ?>
                    <div class="card">
                        <div class="overlay">
                            <button onclick='onDataPopup("delete-profile-gallery", <?= toJson($item, ["id"]) ?>)' class=" icon-button">
                                <span class="material-icons-outlined">
                                    delete
                                </span>
                            </button>
                        </div>
                        <img loading="lazy" src="<?= $item->image ?>" alt="Gallery Image" class="gallery-image">
                    </div>
                <?php } ?>

                <div class="card add-new" onclick="$(`[popup-name='add-profile-gallery']`).popup(true)">
                    <button class="icon-button">
                        <span class="material-icons-outlined">
                            add
                        </span>
                    </button>
                </div>
            </div>
        <?php } ?>
    </section>
    <?php $this->view('includes/side-bars/profile/right', $right_bar) ?>
</div>

<?php $this->view('includes/header/side-bars/profile', $menu_side_bar) ?>

<?php $this->view("includes/modals/profile/upload-image") ?>
<?php $this->view("includes/modals/profile/delete-image") ?>

<script src="<?= ROOT ?>/assets/js/form.js"></script>
<script src="<?= ROOT ?>/assets/js/common.js"></script>

<?php $this->view('includes/header/bottom') ?>