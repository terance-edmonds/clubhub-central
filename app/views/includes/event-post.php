<div class="event-post">
    <div class="top">
        <img loading="lazy" src="<?= $data->club_image ?>" alt="Club Logo" class="club-logo">
        <div class="details">
            <a href="<?= ROOT ?>/club?id=<?= $data->club_id ?>" class="club-title">
                <?= $data->club_name ?>
            </a>
            <p class="other-details">
                <span class="dot"></span>
                <span class="text">
                    <?= dateFromNow($data->start_datetime) ?>
                </span>
            </p>
        </div>
    </div>
    <img loading="lazy" src="<?= $data->image ?>" alt="Post Image" class="post-image">
    <a href="<?= ROOT ?>/events/event?id=<?= $data->id ?>" class="title">
        <?= $data->name ?>
    </a>
    <div class="description-wrap">
        <p class="description truncate-text lines-2">
            <?= $data->description ?>
        </p>
        <span onclick="onReadMore(event)" class="read-more-text">Read More</span>
    </div>
    <div class="details-wrap">
        <div class="detail-wrap">
            <div class="icon">
                <span class="material-icons-outlined">
                    calendar_month
                </span>
            </div>
            <div class="texts">
                <span>
                    <?= displayValue($data->start_datetime, 'date') ?>
                </span>
                <span>
                    <?= displayValue($data->start_datetime, 'time') ?>
                </span>
            </div>
        </div>
        <div class="detail-wrap">
            <div class="icon">
                <span class="material-icons-outlined">
                    fmd_good
                </span>
            </div>
            <div class="texts">
                <span>
                    <?= $data->venue ?>
                </span>
            </div>
        </div>
    </div>
</div>