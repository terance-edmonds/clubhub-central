<head>
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
                <div class="card">
                    <div class="top">
                        <img loading="lazy" src="https://picsum.photos/200/200" alt="Club Logo" class="club-logo">
                        <div class="details">
                            <a href="#" class="club-title">IEEE</a>
                            <p class="other-details">
                                <span class="text">Student Name</span>
                                <span class="dot"></span>
                                <span class="text">6d</span>
                            </p>
                        </div>
                    </div>
                    <p class="description truncate-text lines-2">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolor tenetur nulla nemo ab alias quaerat iusto id nesciunt molestiae error autem perspiciatis commodi nostrum, optio eligendi illum totam, mollitia et!
                        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Asperiores cumque magni quaerat tenetur labore, sed maxime voluptatem quidem, ratione repellendus harum ut fugiat, sunt quia dolores facilis iure ipsa aliquam!
                    </p>
                    <img loading="lazy" src="https://picsum.photos/650/650" alt="Post Image" class="post-image">
                </div>
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
    <?php $this->view('includes/side-bars/profile/right')  ?>
</div>

<script src="<?= ROOT ?>/assets/js/common.js"></script>