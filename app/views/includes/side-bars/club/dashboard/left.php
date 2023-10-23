<section class="side-bar club-dashboard-side-bar left">
    <div class="inner-section no-border profile-section">
        <img src="https://picsum.photos/100/100" alt="Profile Image" class="image">

        <div class="details">
            <span class="name">Terance Edmonds</span>
            <p class="desc">Bio Description here!</p>
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
                <div id="menu-item-<?php echo $val["id"] ?>" class="item">
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
        </div>
    </div>
</section>

<script src="<?= ROOT ?>/assets/js/club/dashboard.js"></script>