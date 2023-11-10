<section class="side-bar right">
    <?php if (Auth::logged()) { ?>
        <div class="inner-section in-numbers-section no-border">
            <p class="title-wrap">
                <span class="lexend">CHC</span> in numbers
            </p>

            <div class="boxes">
                <div class="box">
                    <span class="num">10K</span>
                    <span class="text">Users</span>
                </div>
                <div class="box">
                    <span class="num">75</span>
                    <span class="text">Clubs</span>
                </div>
                <div class="box">
                    <span class="num">150</span>
                    <span class="text">Events</span>
                </div>
            </div>
        </div>
    <?php } ?>

    <div class="inner-section events-section no-border">
        <p class="title-wrap">
            Today's Events
        </p>

        <div class="cards">
            <?php foreach ($events as $event) { ?>
                <div class="card">
                    <img loading="lazy" src="<?= $event->image ?>" alt="Post Image" class="post-image">
                    <div class="details">
                        <a href="<?= ROOT ?>/events/event?id=<?= $event->id ?>" class="title"><?= $event->name ?></a>
                        <p class="date-time">
                            <span>Time</span>
                            <span>:</span>
                            <span><?= displayValue($event->start_datetime, 'time') ?> - <?= displayValue($event->end_datetime, 'time') ?></span>
                        </p>
                        <p class="date-time">
                            <span>Venue</span>
                            <span>:</span>
                            <span class="truncate-text"><?= $event->venue ?></span>
                        </p>
                        <p class="club truncate-text"><?= $event->club_name ?></p>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>