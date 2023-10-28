<?php

$datetime = new DateTime();
$year = $datetime->format('Y');
$month_number = $datetime->format('m');

/* set year and month */
if (!empty($_GET['month'])) $month_number = (int) $_GET['month'];
if (!empty($_GET['year'])) $year = (int) $_GET['year'];

$calendar = new ModCalendar($year, $month_number);
$data = $calendar->create();

extract($data);
?>

<div class="compact-calendar">
    <div class=" center-section">
        <div class="top-bar">
            <a href="<?= ROOT ?><?= $current_path . "?" . $previous_params ?>">
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

            <a href="<?= ROOT ?><?= $current_path . "?" . $next_params ?>">
                <button class="icon-wrap">
                    <span class="material-icons">
                        navigate_next
                    </span>
                </button>
            </a>
        </div>
        <table class="calendar-table">
            <tr class="calendar-header">
                <?php foreach ($week_days_short as $x => $val) { ?>
                    <th align="center"><?= $val ?></th>
                <?php } ?>
            </tr>
            <tbody>
                <?php foreach ($weeks as $week) { ?>
                    <tr>
                        <?php foreach ($week as $day) { ?>
                            <td align="center">
                                <div class="td">
                                    <span class="day"><?= $day ?></span>
                                    <?php if (!empty($day["active"])) { ?>
                                        <span class="dot"></span>
                                    <?php } ?>
                                </div>
                            </td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>