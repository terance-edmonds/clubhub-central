<head>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/header.css">
</head>

<header class="nav-header bottom">
    <div class="container-sections">
        <?php if (Auth::logged()) { ?>
            <section class="center-section">
                <a href="<?= ROOT ?>/" class="nav-item nav-home" data-active="true">
                    <span class="icon material-icons">
                        local_fire_department
                    </span>
                    <span class="text">Feed</span>
                </a>
                <a href="<?= ROOT ?>/events" class="nav-item nav-events">
                    <span class="icon material-icons">
                        calendar_month
                    </span>
                    <span class="text">Events</span>
                </a>
                <a href="<?= ROOT ?>/profile" class="nav-item nav-profile">
                    <span class="icon material-icons-outlined">
                        account_circle
                    </span>
                    <span class="text">Profile</span>
                </a>
            </section>
        <?php } ?>
    </div>
</header>

<script src="<?= ROOT ?>/assets/js/header/index.js"></script>