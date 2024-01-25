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

    <div class="inner-section options-section no-border">
        <p class="title-wrap">
            System Options
        </p>

        <div class="menu">
            <?php
            foreach ($menu as $x => $val) {
            ?>
                <div class="item">
                    <div class="icon-wrap">
                        <span class="material-icons-outlined">
                            <?php echo $val["icon"] ?>
                        </span>
                    </div>
                    <div class="details">
                        <a href="<?= ROOT ?><?php echo $val["path"] ?>" class="title"><?php echo $val["name"] ?></a>
                        <span class="material-icons-outlined">
                            chevron_right
                        </span>
                    </div>
                </div>
            <?php } ?>

            <form method="post">
                <button name="submit" value="logout" class="item logout">
                    <div class="icon-wrap">
                        <span class="material-icons-outlined cl-red">
                            logout
                        </span>
                    </div>
                    <div class="details">
                        <p class="title cl-red">Logout</p>
                    </div>
                </button>
            </form>
        </div>
    </div>

    <div class="inner-section clubs-section no-border">
        <p class="title-wrap">
            Assigned Clubs
        </p>

        <div class="cards">
            <?php if (count($clubs) > 0) { ?>
                <?php foreach ($clubs as $x => $club) { ?>
                    <form method="post">
                        <input type="text" name="club_member_id" value="<?= $club->club_member_id ?>" hidden>
                        <input type="text" name="club_id" value="<?= $club->club_id ?>" hidden>
                        <input type="text" name="club_role" value="<?= $club->club_role ?>" hidden>
                        <button name="submit" value="club-redirect" class="card">
                            <img loading="lazy" src="<?= $club->club_image ?>" alt="Club Logo" class="club-logo">
                            <div class="details">
                                <p class="title"><?= $club->club_name ?></p>
                                <span class="material-icons-outlined">
                                    chevron_right
                                </span>
                            </div>
                        </button>
                    </form>
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