<head>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/cards.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/club.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/side-bar.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/compact-calendar.css">
</head>

<?php $this->view('includes/header') ?>
<?php $this->view('includes/alerts') ?>

<div id="club" class="container container-sections side-padding">
    <?php $this->view('includes/side-bars/club/left', $left_bar) ?>
    <section class="center-section">
        <div class="tabs">
            <a href="<?= ROOT ?>/club?id=<?= $club_id ?>" class="tab" data-active="<?php if ($tab == 'club-posts')
                                                                                        echo 'true'; ?>"><span class="text">Club Posts</span></a>
            <a href="<?= ROOT ?>/club?tab=events&id=<?= $club_id ?>" class="tab" data-active="<?php if ($tab == 'events')
                                                                                                    echo 'true'; ?>"><span class="text">Events</span></a>
            <a href="<?= ROOT ?>/club?tab=gallery&id=<?= $club_id ?>" class="tab" data-active="<?php if ($tab == 'gallery')
                                                                                                    echo 'true'; ?>"><span class="text">Gallery</span></a>
        </div>
        <?php if ($tab == 'club-posts') { ?>
            <div class="cards">
                <?php
                if (count($posts) == 0) {
                    echo "No Club Posts Found.";
                } else {
                    foreach ($posts as $post) {
                        $this->view('includes/club-post', ["data" => $post]);
                    }
                }
                ?>
            </div>
        <?php } else if ($tab == 'events') { ?>
            <div class="cards">
                <?php if (count($events) == 0) {
                    echo "No Event Posts Found";
                } else {
                    foreach ($events as $event) {
                        $this->view('includes/event-post', ["data" => $event]);
                    }
                }  ?>
            </div>
        <?php } else { ?>
            <?php if ($club_role === 'PRESIDENT') { ?>
                <div class="gallery-buttons">
                    <div onclick="$(`[popup-name='add-club-gallery']`).popup(true)" class="gallery-button">
                        <button class="icon-button">
                            <span class="material-icons-outlined">
                                add
                            </span>
                        </button>

                        <span>Add New Image</span>
                    </div>
                </div>
            <?php } ?>
            <div class="gallery">
                <?php if (count($gallery) == 0) {
                    echo "No Gallery Items.";
                } else {
                    foreach ($gallery as $item) { ?>
                        <div class="card">
                            <?php if ($club_role === 'PRESIDENT') { ?> <div class="overlay">
                                    <button <?php if ($club_role === 'PRESIDENT') { ?> onclick='onDataPopup("delete-club-gallery", <?= toJson($item, ["id"]) ?>)' <?php } ?> class=" icon-button">
                                        <span class="material-icons-outlined">
                                            delete
                                        </span>
                                    </button>
                                </div>
                            <?php } ?>
                            <img loading="lazy" src="<?= $item->image ?>" alt="Gallery Image" class="gallery-image">
                        </div>
                <?php }
                } ?>
            </div>
        <?php } ?>
    </section>
    <?php $this->view('includes/side-bars/club/right', $right_bar) ?>
</div>

<?php if ($club_role === 'PRESIDENT') { ?>
    <?php $this->view('includes/modals/club/upload-image') ?>
    <?php $this->view('includes/modals/club/delete-image') ?>
<?php } ?>
<?php $this->view('includes/header/bottom') ?>

<script src="<?= ROOT ?>/assets/js/common.js"></script>
<script src="<?= ROOT ?>/assets/js/cards.js"></script>
<script src="<?= ROOT ?>/assets/js/form.js"></script>