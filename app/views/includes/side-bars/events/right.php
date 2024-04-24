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

<section class="side-bar right">
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
                <a class="box" href="<?= ROOT ?>/club/all">
                    <span class="num">
                        <?= $clubs_count ?>
                    </span>
                    <span class="text">
                        <?= $clubs_count > 1 ? 'Clubs' : 'Club' ?>
                    </span>
                </a>
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

    <div class="inner-section events-section no-border">
        <p class="title-wrap">
            <?php if (!empty($my_events)) { ?>
                My Events
            <?php } else { ?>
                Today's Events
            <?php } ?>
        </p>

        <div class="cards">
            <?php if (count($events) > 0) { ?>
                <?php foreach ($events as $event) { ?>
                    <div class="card">
                        <img loading="lazy" src="<?= $event->image ?>" alt="Post Image" class="post-image">
                        <div class="details">
                            <a href="<?= ROOT ?>/events/event?id=<?= $event->id ?>" class="title">
                                <?= $event->name ?>
                            </a>
                            <p class="date-time">
                                <span>Time</span>
                                <span>:</span>
                                <span>
                                    <?= displayValue($event->start_datetime, 'time') ?> -
                                    <?= displayValue($event->end_datetime, 'time') ?>
                                </span>
                            </p>
                            <p class="date-time">
                                <span>Venue</span>
                                <span>:</span>
                                <span class="truncate-text">
                                    <?= $event->venue ?>
                                </span>
                            </p>
                            <p class="club truncate-text">
                                <?= $event->club_name ?>
                            </p>
                        </div>
                    </div>
                <?php }
            } else { ?>
                <div class="empty-content">
                    <img loading="lazy" src="<?= ROOT ?>/assets/images/other/empty.png" alt="Not Found" class="empty-image">
                    <div class="titles">
                        <span class="title">No Events Yet</span>
                        <span class="sub-title">There are no events scheduled for today</span>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>