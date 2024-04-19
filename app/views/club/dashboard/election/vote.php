<head>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/side-bar.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/dashboard.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/club-dashboard.css">
</head>

<?php $this->view('includes/header') ?>

<?php $this->view('includes/alerts') ?>

<div id="club-dashboard-election-vote" class="container container-sections side-padding club-dashboard dashboard-container">
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
                                                            echo 'true'; ?>" href="<?= ROOT ?>/club/dashboard/election/vote?election=<?= $election_id ?>&tab=president"><button class="button">President</button></a>
                    <a class="action-link" data-active="<?php if ($tab == 'secretary')
                                                            echo 'true'; ?>" href="<?= ROOT ?>/club/dashboard/election/vote?election=<?= $election_id ?>&tab=secretary"><button class="button">Secretary</button></a>
                    <a class="action-link" data-active="<?php if ($tab == 'treasurer')
                                                            echo 'true'; ?>" href="<?= ROOT ?>/club/dashboard/election/vote?election=<?= $election_id ?>&tab=treasurer"><button class="button">Treasurer</button></a>
                </div>
            </div>

            <form class="form" method="post">
                <?php if (count($candidate_members_data) == 0) { ?>
                    <p>No Records.</p>
                <?php } ?>
                <div class="candidates">
                    <?php foreach ($candidate_members_data as $club_member) { ?>
                        <label class="candidate">
                            <input type="radio" name="candidate" value="<?= $club_member->id ?>" hidden />
                            <img src="<?php echo (!empty($club_member->image)) ? $club_member->image : ROOT . '/assets/images/other/empty-profile.jpg' ?>" alt="Profile Image" class="image">
                            <p class="name"><?= $club_member->first_name ?> <?= $club_member->last_name ?></p>
                        </label>
                    <?php } ?>
                </div>

                <button type="submit" name="submit" value="vote-election" class="button contained w-content">Vote</button>
            </form>
        </div>
    </section>
</div>

<?php $this->view('includes/header/side-bars/club-dashboard', $menu_side_bar) ?>

<script src="<?= ROOT ?>/assets/js/form.js"></script>