<head>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/cards.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/profile.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/side-bar.css">
</head>

<?php $this->view('includes/header') ?>

<div id="profile" class="container container-sections side-padding">
    <?php $this->view('includes/side-bars/profile/left')  ?>
    <section class="center-section">
        <div class="tabs">
            <a href="<?= ROOT ?>/profile" class="tab" data-active="<?php if ($tab == 'gallery') echo 'true'; ?>"><span class="text">Gallery</span></a>
            <a href="<?= ROOT ?>/profile?tab=club-posts" class="tab" data-active="<?php if ($tab == 'club-posts') echo 'true'; ?>"><span class="text">Club Posts</span></a>
        </div>
        <?php if ($tab == 'club-posts') { ?>
            <div class="cards">
                <?php $this->view('includes/club-post') ?>
            </div>
        <?php } else { ?>
            <div class="gallery">
                <div class="card">
                    <img loading="lazy" src="https://picsum.photos/200/200" alt="Gallery Image" class="gallery-image">
                </div>
                <div class="card">
                    <img loading="lazy" src="https://picsum.photos/200/200" alt="Gallery Image" class="gallery-image">
                </div>
                <div class="card">
                    <img loading="lazy" src="https://picsum.photos/200/200" alt="Gallery Image" class="gallery-image">
                </div>
                <div class="card">
                    <img loading="lazy" src="https://picsum.photos/200/200" alt="Gallery Image" class="gallery-image">
                </div>
                <div class="card">
                    <img loading="lazy" src="https://picsum.photos/200/200" alt="Gallery Image" class="gallery-image">
                </div>
                <div class="card">
                    <img loading="lazy" src="https://picsum.photos/200/200" alt="Gallery Image" class="gallery-image">
                </div>
            </div>
        <?php } ?>
    </section>
    <?php $this->view('includes/side-bars/profile/right', $menu_data)  ?>
</div>

<script src="<?= ROOT ?>/assets/js/common.js"></script>