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
            <form class="form" method="post">
                <input name="club_election_id" type="text" hidden value="<?= $election->id ?>">
                <div class="input-wrap">
                    <label for="president">President</label>
                    <select name="president" id="president">
                        <option value="" selected disabled hidden>Choose Candidate</option>
                        <?php foreach ($candidate_members_data as $club_member) { ?>
                            <option value="<?= $club_member->id ?>">
                                <?= $club_member->first_name ?>
                                <?= $club_member->last_name ?>
                            </option>
                        <?php } ?>
                    </select>
                    <?php if (!empty($errors['president'])) : ?>
                        <small>
                            <?= $errors['president'] ?>
                        </small>
                    <?php endif; ?>
                </div>
                <div class="input-wrap">
                    <label for="secretary">Secretary</label>
                    <select name="secretary" id="secretary">
                        <option value="" selected disabled hidden>Choose Candidate</option>
                        <?php foreach ($candidate_members_data as $club_member) { ?>
                            <option value="<?= $club_member->id ?>">
                                <?= $club_member->first_name ?>
                                <?= $club_member->last_name ?>
                            </option>
                        <?php } ?>
                    </select>
                    <?php if (!empty($errors['secretary'])) : ?>
                        <small>
                            <?= $errors['secretary'] ?>
                        </small>
                    <?php endif; ?>
                </div>
                <div class="input-wrap">
                    <label for="treasurer">Treasurer</label>
                    <select name="treasurer" id="treasurer">
                        <option value="" selected disabled hidden>Choose Candidate</option>
                        <?php foreach ($candidate_members_data as $club_member) { ?>
                            <option value="<?= $club_member->id ?>">
                                <?= $club_member->first_name ?>
                                <?= $club_member->last_name ?>
                            </option>
                        <?php } ?>
                    </select>
                    <?php if (!empty($errors['treasurer'])) : ?>
                        <small>
                            <?= $errors['treasurer'] ?>
                        </small>
                    <?php endif; ?>
                </div>

                <button type="submit" name="submit" value="vote-election" class="button contained w-content">Vote</button>
            </form>
        </div>
    </section>
</div>

<?php $this->view('includes/header/side-bars/club-dashboard', $menu_side_bar) ?>

<script src="<?= ROOT ?>/assets/js/form.js"></script>