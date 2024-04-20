<head>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/cards.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/profile.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/side-bar.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/compact-calendar.css">
</head>

<?php $this->view('includes/header') ?>

<?php $this->view('includes/alerts') ?>

<div id="profile" class="container container-sections side-padding">
    <?php $this->view('includes/side-bars/profile/public/left', $left_bar) ?>
    <section class="center-section">
        <div class="tabs">
            <a href="<?= ROOT ?>/profile" class="tab" data-active="<?php if ($tab == 'gallery')
                                                                        echo 'true'; ?>"><span class="text">Gallery</span></a>
            <a href="<?= ROOT ?>/profile?tab=club-posts" class="tab" data-active="<?php if ($tab == 'club-posts')
                                                                                        echo 'true'; ?>"><span class="text">Club Posts</span></a>
        </div>
        <?php if ($tab == 'club-posts') { ?>
            <div class="cards">
                <?php
                if (count($posts) == 0) {
                    echo "No Club Posts Yet.";
                } else {
                    foreach ($posts as $post) {
                        $this->view('includes/club-post', ["data" => $post]);
                    }
                }
                ?>
            </div>
        <?php } else { ?>
            <div class="gallery">
                <?php if (count($gallery) == 0) {
                    echo "No Gallery Items.";
                } else {
                    foreach ($gallery as $item) { ?>
                        <div class="card">
                            <img loading="lazy" src="<?= $item->image ?>" alt="Gallery Image" class="gallery-image">
                        </div>
                <?php }
                } ?>
            </div>
        <?php } ?>
    </section>
    <?php $this->view('includes/side-bars/profile/public/right', $right_bar) ?>
</div>

<?php $this->view('includes/header/side-bars/profile', $menu_side_bar) ?>

<?php $this->view('includes/header/bottom') ?>

<script src="<?= ROOT ?>/assets/js/form.js"></script>
<script src="<?= ROOT ?>/assets/js/common.js"></script>
<script src="<?= ROOT ?>/assets/js/cards.js"></script>