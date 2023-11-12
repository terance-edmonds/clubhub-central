<?php
$side_bar_user = new User();
$side_bar_auth_user_id = Auth::getId();
$side_bar_user = $side_bar_user->one(["id" => $side_bar_auth_user_id]);
?>

<section class="side-bar club-dashboard-side-bar left">
    <div class="inner-section no-border profile-section">
        <img src="<?php echo (!empty($side_bar_user->image)) ? $side_bar_user->image : ROOT . '/assets/images/other/empty-profile.jpg' ?>" alt="Profile Image" class="image">

        <div class="details">
            <span class="name"><?= $side_bar_user->first_name ?> <?= $side_bar_user->last_name ?></span>
            <p class="desc"><?= $side_bar_user->description ?></p>
        </div>
    </div>

    <div class="inner-section menu-section no-border">
        <div class="title-card">
            <img loading="lazy" src="https://picsum.photos/110/110" alt="Club Logo" class="club-logo">
            <div class="details">
                <a href="<?= ROOT ?>/club?id=" class="title">IEEE Dashboard</a>
                <span class="material-icons-outlined">
                    chevron_right
                </span>
            </div>
        </div>

        <div class="menu">
            <?php
            foreach ($menu as $x => $val) {
            ?>
                <div data-active="<?php echo $val["active"] ?>" class="item">
                    <div class="icon-wrap">
                        <span class="material-icons-outlined">
                            <?php echo $val["icon"] ?>
                        </span>
                    </div>
                    <div class="details">
                        <a href="<?= ROOT ?><?php echo (is_array($val["path"])) ? $val["path"][0] : $val["path"] ?>" class="title"><?php echo $val["name"] ?></a>
                        <span class="material-icons-outlined">
                            chevron_right
                        </span>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>