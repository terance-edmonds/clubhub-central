<section class="side-bar profile-side-bar right">
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

    <div class="inner-section options-section no-border">
        <p class="title-wrap">
            System Options
        </p>

        <div class="menu">
            <?php
            foreach ($menu as $x => $val) {
            ?>
                <div class="item">
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

            <form action="" method="post">
                <button name="submit" value="logout" class="item logout">
                    <div class="icon-wrap">
                        <span class="material-icons-outlined cl-red">
                            logout
                        </span>
                    </div>
                    <div class="details">
                        <p class="title cl-red">Logout</p>
                    </div>
                </button>
            </form>
        </div>
    </div>

    <div class="inner-section clubs-section no-border">
        <p class="title-wrap">
            Assigned Clubs
        </p>

        <div class="cards">
            <?php if (count($clubs) == 0) { ?>
                <div class="card">
                    <img loading="lazy" src="https://picsum.photos/110/110" alt="Club Logo" class="club-logo">
                    <div class="details">
                        <a href="<?= ROOT ?>/club/dashboard" class="title">IEEE</a>
                        <span class="material-icons-outlined">
                            chevron_right
                        </span>
                    </div>
                </div>
            <?php } ?>
        </div>

        <?php if (count($clubs) != 0) { ?>
            <div class="empty-content">
                <img loading="lazy" src="<?= ROOT ?>/assets/images/other/empty.png" alt="Not Found" class="empty-image">
                <div class="titles">
                    <span class="title">No Clubs Yet</span>
                    <span class="sub-title">You are not assigned under any club yet</span>
                </div>
            </div>
        <?php } ?>
    </div>
</section>