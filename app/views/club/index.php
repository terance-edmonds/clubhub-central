<head>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/cards.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/club.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/side-bar.css">
</head>

<?php $this->view('includes/header') ?>

<div id="club" class="container container-sections side-padding">
    <?php $this->view('includes/side-bars/club/left')  ?>
    <section class="center-section">
        <div class="tabs">
            <a href="<?= ROOT ?>/club?id=<?php $club_id ?>" class="tab" data-active="<?php if ($tab == 'club-posts') echo 'true'; ?>"><span class="text">Club Posts</span></a>
            <a href="<?= ROOT ?>/club?tab=events&id=<?php $club_id ?>" class="tab" data-active="<?php if ($tab == 'events') echo 'true'; ?>"><span class="text">Events</span></a>
            <a href="<?= ROOT ?>/club?tab=gallery&id=<?php $club_id ?>" class="tab" data-active="<?php if ($tab == 'gallery') echo 'true'; ?>"><span class="text">Gallery</span></a>
        </div>
        <?php if ($tab == 'club-posts') { ?>
            <div class="cards">
                <?php $this->view('includes/club-post') ?>
            </div>
        <?php } else if ($tab == 'events') { ?>
            <div class="cards">
                <?php $this->view('includes/event-post') ?>
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
    <?php $this->view('includes/side-bars/club/right')  ?>
</div>

<script src="<?= ROOT ?>/assets/js/common.js"></script>