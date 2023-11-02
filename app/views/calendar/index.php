<head>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/calendar.css">
</head>

<?php $this->view('includes/header') ?>

<div id="calendar" class="container container-sections">
    <div class="center-section">
        <div class="top-bar">
            <a href="<?= ROOT ?>/calendar?<?= $previous_params ?>">
                <button class="icon-wrap">
                    <span class="material-icons">
                        navigate_before
                    </span>
                </button>
            </a>

            <div class="center">
                <p class="month">
                    <?= $month ?>
                </p>
                <p class="year">
                    <?= $year ?>
                </p>
            </div>

            <a href="<?= ROOT ?>/calendar?<?= $next_params ?>">
                <button class="icon-wrap">
                    <span class="material-icons">
                        navigate_next
                    </span>
                </button>
            </a>
        </div>
        <table class="calendar-table">
            <tr class="calendar-header">
                <?php foreach ($week_days as $x => $val) { ?>
                    <th><?= $val ?></th>
                <?php } ?>
            </tr>
            <tbody>

                <?php foreach ($weeks as $week) { ?>
                    <tr>
                        <?php foreach ($week as $data) { ?>
                            <td class="calendar-cell">
                                <div class="cell-content">
                                    <div class="top">
                                        <span><?= $data["day"] ?></span>
                                    </div>
                                    <div class="content">
                                        <?php if (!empty($data["items"])) { ?>
                                            <?php foreach ($data["items"] as $key => $item) { ?>
                                                <div class="item">
                                                    <p class="name"><?= $item["name"] ?></p>
                                                    <div class="pop-over">
                                                        <p class="name"><?= $item["name"] ?></p>
                                                        <div class="info-wrap date">
                                                            <div class="icon-wrap">
                                                                <span class="material-icons-outlined">
                                                                    today
                                                                </span>
                                                            </div>
                                                            <span class="text"><?= displayValue($item["date"], 'date') ?></span>
                                                        </div>
                                                        <div class="info-wrap time">
                                                            <div class="icon-wrap">
                                                                <span class="material-icons-outlined">
                                                                    schedule
                                                                </span>
                                                            </div>
                                                            <span class="text"><?= displayValue($item["start_time"], 'time') ?></span>
                                                        </div>
                                                        <div class="info-wrap location">
                                                            <div class="icon-wrap">
                                                                <span class="material-icons-outlined">
                                                                    share_location
                                                                </span>
                                                            </div>
                                                            <span class="text"><?= displayValue($item["location"]) ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                        <?php }
                                        } ?>
                                    </div>
                                </div>
                            </td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>