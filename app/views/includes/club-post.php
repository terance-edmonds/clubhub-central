<div class="club-post">
    <div class="top">
        <img loading="lazy" src="<?= $data->club_image ?>" alt="Club Logo" class="club-logo">
        <div class="details">
            <a href="<?= ROOT ?>/club?id=<?= $data->club_id ?>" class="club-title"><?= $data->club_name ?></a>
            <p class="other-details">
                <span class="text post-title"><?= $data->post_name ?></span>
                <span class="dot"></span>
                <span class="text datetime"><?= dateFromNow($data->created_datetime) ?></span>
            </p>
        </div>
    </div>
    <p class="description truncate-text lines-2">
        <?= $data->description ?>
    </p>
    <img loading="lazy" src="<?= $data->image ?>" alt="Post Image" class="post-image">
</div>