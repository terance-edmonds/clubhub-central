<head>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/header.css">
</head>

<header class="nav-header">
    <div class="container-sections">
        <section class="logo-section">
            <a href="<?= ROOT ?>"><img src="<?= ROOT ?>/assets/images/logo/logo-text.png" alt="Logo" class="logo"></a>
        </section>

        <?php if (Auth::logged()) { ?>
            <section class="center-section">
                <a id="nav-home" href="<?= ROOT ?>/" class="nav-item nav-home" data-active="true">
                    <span class="icon material-icons">
                        local_fire_department
                    </span>
                    <span class="text">Feed</span>
                </a>
                <a id="nav-events" href="<?= ROOT ?>/events" class="nav-item nav-events">
                    <span class="icon material-icons">
                        calendar_month
                    </span>
                    <span class="text">Events</span>
                </a>
                <a id="nav-profile" href="<?= ROOT ?>/profile" class="nav-item nav-profile">
                    <span class="icon material-icons-outlined">
                        account_circle
                    </span>
                    <span class="text">Profile</span>
                </a>
            </section>

            <section class="notification-section">
                <div class="nav-item notification-item">
                    <div class="icon-wrap">
                        <div class="active"></div>
                        <span class="icon material-icons-outlined">
                            notifications
                        </span>
                    </div>
                    <span class="text">Notifications</span>
                </div>
                <div class="nav-item menu-item">
                    <div onclick="onMenuClick(event)" class="icon-wrap">
                        <span class="icon material-icons-outlined">
                            menu
                        </span>
                    </div>
                </div>
            </section>
        <?php } ?>
    </div>
</header>

<script src="<?= ROOT ?>/assets/js/header/index.js"></script>
<script src="<?= ROOT ?>/assets/js/header/top.js"></script>