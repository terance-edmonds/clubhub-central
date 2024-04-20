<?php
$_users = new User();
$users_count = $_users->find([], ["count(*) as count"]);
$users_count = shortNumber($users_count[0]->count);

$_clubs = new Clubs();
$clubs_count = $_clubs->find([], ["count(*) as count"]);
$clubs_count = shortNumber($clubs_count[0]->count);

$_events = new Event();
$events_count = $_events->find([], ["count(*) as count"]);
$events_count = shortNumber($events_count[0]->count);
?>


<section class="side-bar profile-side-bar right">
    <?php if (Auth::logged()) { ?>
        <div class="inner-section in-numbers-section no-border">
            <p class="title-wrap">
                <span class="lexend">CHC</span> in numbers
            </p>

            <div class="boxes">
                <div class="box">
                    <span class="num">
                        <?= $users_count ?>
                    </span>
                    <span class="text">
                        <?= $users_count > 1 ? 'Users' : 'User' ?>
                    </span>
                </div>
                <div class="box">
                    <span class="num">
                        <?= $clubs_count ?>
                    </span>
                    <span class="text">
                        <?= $clubs_count > 1 ? 'Clubs' : 'Club' ?>
                    </span>
                </div>
                <div class="box">
                    <span class="num">
                        <?= $events_count ?>
                    </span>
                    <span class="text">
                        <?= $events_count > 1 ? 'Events' : 'Event' ?>
                    </span>
                </div>
            </div>
        </div>
    <?php } ?>

    <div class="inner-section clubs-section no-border">
        <p class="title-wrap">
            Joined Clubs
        </p>

        <div class="cards">
            <?php if (count($clubs) > 0) { ?>
                <?php foreach ($clubs as $x => $club) { ?>
                    <a href="<?= ROOT ?>/club?id=<?= $club->club_id ?>">
                        <button name="submit" value="club-redirect" class="card">
                            <img loading="lazy" src="<?= $club->club_image ?>" alt="Club Logo" class="club-logo">
                            <div class="details">
                                <p class="title"><?= $club->club_name ?></p>
                                <span class="material-icons-outlined">
                                    chevron_right
                                </span>
                            </div>
                        </button>
                    </a>
                <?php }
            } else { ?>
                <div class="empty-content">
                    <img loading="lazy" src="<?= ROOT ?>/assets/images/other/empty.png" alt="Not Found" class="empty-image">
                    <div class="titles">
                        <span class="title">No Clubs Yet</span>
                        <span class="sub-title">You are not assigned under any club yet</span>
                    </div>
                </div>
            <?php } ?>

        </div>
    </div>
</section>