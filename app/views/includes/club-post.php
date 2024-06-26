<div class="club-post">
    <div class="top">
        <img loading="lazy" src="<?php echo empty($data->club_image) ? ROOT . '/assets/images/other/empty-image.png' : $data->club_image; ?>" alt="Club Logo" class="club-logo">
        <div class="details">
            <a href="<?= ROOT ?>/club?id=<?= $data->club_id ?>" class="club-title"><?= $data->club_name ?></a>
            <p class="other-details">
                <span class="text post-title"><?= $data->post_name ?></span>
                <span class="dot"></span>
                <span class="text datetime"><?= dateFromNow($data->created_datetime) ?></span>
            </p>
        </div>
    </div>
    <div class="description-wrap">
        <p class="description truncate-text lines-2">
            <?= $data->description ?>
        </p>
        <span onclick="onReadMore(event)" class="read-more-text">Read More</span>
    </div>
    <img loading="lazy" src="<?= $data->image ?>" alt="Post Image" class="post-image">
</div>