<section class="side-bar club-side-bar right">
    <div class="inner-section clubs-section no-border">
        <p class="title-wrap">
            Club Administrators
        </p>
        <div class="cards">
            <?php if (!empty($president)) { ?>
                <div class="card">
                    <img loading="lazy" src="<?php echo (!empty($president->image)) ? $president->image : ROOT . '/assets/images/other/empty-profile.jpg' ?>" alt="Profile Image" class="profile-image">
                    <div class="details">
                        <div class="titles-wrap">
                            <a href="<?= ROOT ?>/user?id=<?= $president->user_id ?>" class="title"><?= $president->first_name ?> <?= $president->last_name ?></a>
                            <span class="sub-title">President</span>
                        </div>
                        <span class="material-icons-outlined">
                            chevron_right
                        </span>
                    </div>
                </div>
            <?php } ?>
            <?php if (!empty($secretary)) { ?>
                <div class="card">
                    <img loading="lazy" src="<?php echo (!empty($secretary->image)) ? $secretary->image : ROOT . '/assets/images/other/empty-profile.jpg' ?>" alt="Profile Image" class="profile-image">
                    <div class="details">
                        <div class="titles-wrap">
                            <a href="<?= ROOT ?>/user?id=<?= $secretary->user_id ?>" class="title"><?= $secretary->first_name ?> <?= $secretary->last_name ?></a>
                            <span class="sub-title">Secretary</span>
                        </div>
                        <span class="material-icons-outlined">
                            chevron_right
                        </span>
                    </div>
                </div>
            <?php } ?>
            <?php if (!empty($treasurer)) { ?>
                <div class="card">
                    <img loading="lazy" src="<?php echo (!empty($treasurer->image)) ? $treasurer->image : ROOT . '/assets/images/other/empty-profile.jpg' ?>" alt="Profile Image" class="profile-image">
                    <div class="details">
                        <div class="titles-wrap">
                            <a href="<?= ROOT ?>/user?id=<?= $treasurer->user_id ?>" class="title"><?= $treasurer->first_name ?> <?= $treasurer->last_name ?></a>
                            <span class="sub-title">Treasurer</span>
                        </div>
                        <span class="material-icons-outlined">
                            chevron_right
                        </span>
                    </div>
                <?php } ?>
                </div>
        </div>
    </div>

    <div class="inner-section events-section no-border">
        <p class="title-wrap">
            Today's Events
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