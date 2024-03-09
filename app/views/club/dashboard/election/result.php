<head>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/side-bar.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/dashboard.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/club-dashboard.css">
</head>

<?php $this->view('includes/header') ?>

<?php $this->view('includes/alerts') ?>

<div id="club-dashboard-election-result" class="container container-sections side-padding club-dashboard dashboard-container">
    <?php $this->view('includes/side-bars/club/dashboard/left', $left_bar) ?>

    <section class="center-section">
        <div class="title-bar">
            <div class="title-wrap column">
                <span class="title"><?= $election->title ?></span>
                <p class="description"><?= $election->description ?></p>
            </div>
        </div>

        <div class="content-section">
            <div class="actions-wrap">
                <div class="action-buttons">
                    <a class="action-link" data-active="<?php if ($tab == 'president')
                                                            echo 'true'; ?>" href="<?= ROOT ?>/club/dashboard/election/result?club_id=<?= $club_id ?>&election_id=<?= $election_id ?>&tab=president"><button class="button">President</button></a>
                    <a class="action-link" data-active="<?php if ($tab == 'secretary')
                                                            echo 'true'; ?>" href="<?= ROOT ?>/club/dashboard/election/result?club_id=<?= $club_id ?>&election_id=<?= $election_id ?>&tab=secretary"><button class="button">Secretary</button></a>
                    <a class="action-link" data-active="<?php if ($tab == 'treasurer')
                                                            echo 'true'; ?>" href="<?= ROOT ?>/club/dashboard/election/result?club_id=<?= $club_id ?>&election_id=<?= $election_id ?>&tab=treasurer"><button class="button">Treasurer</button></a>
                </div>
            </div>

            <div class="results-content">
                <?php foreach ($election_results as $result) { ?>
                    <div class="result-item">
                        <div class="user-image">
                            <img src="<?php echo (!empty($result->image)) ? $result->image : ROOT . '/assets/images/other/empty-profile.jpg' ?>" alt="User" class="image">
                        </div>
                        <div class="progress" data-progress="<?= number_format($result->vote_percentage, 1) ?>">
                            <div class="progress-bar"></div>
                            <div class="progress-section">
                                <span class="name"><b><?= $result->first_name ?> <?= $result->last_name ?></b></span>
                                <span class="votes"><?= $result->votes ?></span>
                            </div>
                            <div class="progress-section">
                                <b><?= number_format($result->vote_percentage, 1) ?>%</b>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
</div>

<?php $this->view('includes/header/side-bars/club-dashboard', $menu_side_bar) ?>

<script src="<?= ROOT ?>/assets/js/club/dashboard/election-result.js"></script>
<script src="<?= ROOT ?>/assets/js/form.js"></script>