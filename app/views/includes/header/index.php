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
            <?php
            if (Auth::logged()) {
                $user_notifications = new UserNotifications();
                $notifications = $user_notifications->find([
                    "notification_state.user_id" => Auth::getId()
                ], ["user_notifications.id as id", "title", "description", "link", "notification_state.id as notification_state_id", "notification_state.mark_as_read"],  [
                    ["table" => "user_notification_state", "as" => "notification_state", "on" => "user_notifications.id = notification_state.notification_id"]
                ]);
            }
            ?>
            <section class="notification-section">
                <div class="nav-item notification-wrap">
                    <div onclick="onNotificationsClick(event)" class="nav-item notification-icon-wrap">
                        <div class="icon-wrap">
                            <?php if (!empty($notifications) and count($notifications) != 0) {
                                if (in_array('0', array_column($notifications, 'mark_as_read'))) { ?>
                                    <div class="active"></div>
                            <?php }
                            } ?>
                            <span class="icon material-icons-outlined">
                                notifications
                            </span>
                        </div>
                        <span class="text">Notifications</span>
                    </div>
                    <div class="notification-list-wrap">
                        <div class="notification-list">
                            <?php if (empty($notifications) or count($notifications) == 0) { ?>
                                <div class="notification-item empty">
                                    <p class="title">No Notifications.</p>
                                </div>
                            <?php } else { ?>
                                <?php foreach ($notifications as $notification) { ?>
                                    <div data-notification="<?= $notification->notification_state_id ?>" class="notification-item" data-unread="<?= displayValue(!$notification->mark_as_read, 'boolean') ?>">
                                        <p class="title"><?= $notification->title ?></p>
                                        <p class="description truncate-text"><?= $notification->description ?></p>
                                        <div class="buttons">
                                            <?php if (!empty($notification->link)) { ?>
                                                <a href="<?= $notification->link ?>">
                                                    <button type="button" class="icon-button cl-blue">
                                                        <span class="material-icons-outlined">
                                                            link
                                                        </span>
                                                    </button>
                                                </a>
                                            <?php } ?>
                                            <button onclick="onDeleteNotification(event, <?= $notification->notification_state_id ?>)" type="button" class="icon-button cl-red">
                                                <span class="material-icons-outlined">
                                                    delete
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                <?php
                                } ?>
                            <?php } ?>
                        </div>
                    </div>
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