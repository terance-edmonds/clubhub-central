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

<div id="nav-menu" class="side-menu side-bar">
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

    <div class="right-section">
        <div class="inner-section">
            <div class="title-wrap">
                <p class="title">Event Calendar</p>
            </div>

            <div class="content">
                <?php $this->view('includes/calendar', $calendar_data) ?>
            </div>
        </div>
    </div>
</div>