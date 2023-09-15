<head>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/events.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/side-bar.css">
</head>

<?php $this->view('includes/header') ?>

<div id="events" class="container container-sections side-padding">
    <?php $this->view('includes/side-bars/left')  ?>
    <section class="center-section">
        <div class="card">
            <div class="top">
                <img loading="lazy" src="https://picsum.photos/200/200" alt="Club Logo" class="club-logo">
                <div class="details">
                    <a href="#" class="club-title">IEEE</a>
                    <p class="other-details">
                        <span class="dot"></span>
                        <span class="text">6d</span>
                    </p>
                </div>
            </div>
            <img loading="lazy" src="https://picsum.photos/650/650" alt="Post Image" class="post-image">
            <a href="#" class="title">Event Name</a>
            <p class="description truncate-text lines-2">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolor tenetur nulla nemo ab alias quaerat iusto id nesciunt molestiae error autem perspiciatis commodi nostrum, optio eligendi illum totam, mollitia et!
                Lorem ipsum dolor sit, amet consectetur adipisicing elit. Asperiores cumque magni quaerat tenetur labore, sed maxime voluptatem quidem, ratione repellendus harum ut fugiat, sunt quia dolores facilis iure ipsa aliquam!
            </p>
            <div class="details-wrap">
                <div class="detail-wrap">
                    <div class="icon">
                        <span class="material-icons-outlined">
                            calendar_month
                        </span>
                    </div>
                    <div class="texts">
                        <span>24th August</span>
                        <span>11.00 A.M</span>
                    </div>
                </div>
                <div class="detail-wrap">
                    <div class="icon">
                        <span class="material-icons-outlined">
                            fmd_good
                        </span>
                    </div>
                    <div class="texts">
                        <span>UCSC Grounds</span>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <?php $this->view('includes/side-bars/right')  ?>
</div>