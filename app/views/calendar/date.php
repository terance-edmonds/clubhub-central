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
                        <div class="date-section">
                            <p class="date">
                                <?= dateFormat($item->start_datetime, 'd M') ?>
                            </p>
                            <p class="time">
                                <?= displayValue($item->start_datetime, 'time') ?>
                            </p>
                        </div>

                        <div class="content-section">
                            <a href="<?= ROOT ?>/events/event?id=<?= $item->id ?>" class="name"><?= $item->name ?></a>
                            <p class="date">
                                <?php
                                $start_date = dateFormat($item->start_datetime, 'Y-m-d h:i A');
                                $end_date = dateFormat($item->end_datetime, 'Y-m-d h:i A');

                                echo $start_date . ' - ' . $end_date;
                                ?>
                            </p>
                            <p class="description truncate-text lines-2">
                                <?= $item->description ?>
                            </p>
                        </div>
                    </div>
            <?php }
            } ?>
        </div>
    </div>

</div>

<?php $this->view('includes/header/bottom') ?>