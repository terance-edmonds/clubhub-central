<head>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/calendar.css">
</head>

<?php $this->view('includes/header') ?>

<div id="calendar-date" class="container container-sections">
    <div class="center-section">
        <div class="top-bar">
            <a href="<?= ROOT ?>/calendar/date?<?= $previous_params ?>">
                <button class="icon-wrap">
                    <span class="material-icons">
                        navigate_before
                    </span>
                </button>
            </a>

            <div class="center">
                <p class="day">
                    <?= $day ?>
                </p>
                <p class="month">
                    <?= $month ?>
                </p>
                <p class="year">
                    <?= $year ?>
                </p>
            </div>

            <a href="<?= ROOT ?>/calendar/date?<?= $next_params ?>">
                <button class="icon-wrap">
                    <span class="material-icons">
                        navigate_next
                    </span>
                </button>
            </a>
        </div>
        <div class="calendar-content">
            <?php if (!empty($data["items"])) { ?>
                <?php
                foreach ($data["items"] as $key => $item) {
                ?>
                    <div class="item">
                        <p class="name">
                            <?= $item->name ?>
                        </p>
                        <div class="pop-over">
                            <p class="name">
                                <?= $item->name ?>
                            </p>
                            <div class="info-wrap date">
                                <div class="icon-wrap">
                                    <span class="material-icons-outlined">
                                        today
                                    </span>
                                </div>
                                <span class="text">
                                    <?= displayValue($item->start_datetime, 'date') ?>
                                </span>
                            </div>
                            <div class="info-wrap time">
                                <div class="icon-wrap">
                                    <span class="material-icons-outlined">
                                        schedule
                                    </span>
                                </div>
                                <span class="text">
                                    <?= displayValue($item->start_datetime, 'time') ?>
                                </span>
                            </div>
                            <div class="info-wrap location">
                                <div class="icon-wrap">
                                    <span class="material-icons-outlined">
                                        share_location
                                    </span>
                                </div>
                                <span class="text">
                                    <?= displayValue($item->venue) ?>
                                </span>
                            </div>
                        </div>
                    </div>
            <?php }
            } ?>
        </div>
    </div>

</div>

<?php $this->view('includes/header/bottom') ?>