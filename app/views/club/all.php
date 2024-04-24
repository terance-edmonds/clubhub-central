<head>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/cards.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/club.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/clubs.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/side-bar.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/compact-calendar.css">
</head>

<?php $this->view('includes/header') ?>
<?php $this->view('includes/alerts') ?>

<div id="clubs" class="container container-sections side-padding">
    <?php $this->view('includes/side-bars/events/left', $left_bar) ?>
    <section class="center-section">
        <div class="clubs-section">
            <?php if (count($clubs) == 0) { ?>
                <div class="card">
                    <p>No Clubs Yet.</p>
                </div>
            <?php } ?>
            <?php foreach ($clubs as $club) { ?>
                <a href="<?= ROOT ?>/club?id=<?= $club->id ?>" target="_blank">
                    <div class="card">
                        <div class="top-content">
                            <img loading="lazy" src="<?php echo empty($club->image) ? ROOT . '/assets/images/other/empty-image.png' : $club->image; ?>" alt="Club Logo" class="club-logo" />

                            <div class="details">
                                <div class="text-details">
                                    <p class="title"><?= $club->name ?></p>
                                </div>
                                <span class="material-icons-outlined">
                                    chevron_right
                                </span>
                            </div>
                        </div>
                        <p class="description">
                            <?= $club->description ?>
                        </p>
                    </div>
                </a>
            <?php } ?>
        </div>
    </section>
    <?php $this->view('includes/side-bars/events/right', $right_bar) ?>
</div>

<?php $this->view('includes/header/side-bars/home', $menu_side_bar) ?>

<?php $this->view('includes/header/bottom') ?>