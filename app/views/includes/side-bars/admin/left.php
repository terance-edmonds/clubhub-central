<section class="side-bar admin-dashboard-side-bar left">
    <div class="inner-section no-border profile-section">
        <img src="https://picsum.photos/100/100" alt="Profile Image" class="image">

        <div class="details">
            <span class="name">Terance Edmonds</span>
            <p class="desc">Bio Description here!</p>
        </div>
    </div>

    <div class="inner-section menu-section no-border">
        <div class="title-card">
            <img loading="lazy" src="<?= ROOT ?>/assets/images/logo/logo.png" alt="ClubHub Logo" class="logo">
            <div class="details">
                <p class="title">Admin Dashboard</p>
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