<head>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/side-bar.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/dashboard.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/club-dashboard.css">
</head>

<?php $this->view('includes/header') ?>

<div id="club-dashboard-meeting" class="container container-sections side-padding club-dashboard dashboard-container">
    <?php $this->view('includes/side-bars/club/dashboard/left', $left_bar) ?>

    <section class="center-section">
        <div class="title-bar">
            <div class="title-wrap">
                <span class="title">Meetings</span>
                <a href="<?= ROOT ?>/club/dashboard/meetings/add">
                    <button class="button" data-variant="outlined" data-type="icon" data-size="small">
                        <span>New Meeting</span>
                        <span class="material-icons-outlined">
                            add
                        </span>
                    </button>
                </a>
            </div>

            <div class="input-wrap search-input">
                <div class="input">
                    <span class="icon material-icons-outlined">
                        search
                    </span>
                    <input type="text" placeholder="Search">
                </div>
            </div>
        </div>

        <div class="top-buttons">
            <a href="<?= ROOT ?>/club/dashboard/meetings/attendance">
                <button class="button w-content" data-variant="outlined" data-type="icon" data-size="small">
                    <span>Mark Attendance</span>
                    <span class="material-icons-outlined">
                        how_to_reg
                    </span>
                </button>
            </a>
        </div>

        <div class="content-section">
            <div class="table-wrap">
                <table>
                    <tr class="table-header">
                        <th>Meeting Name</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>No. Participants</th>
                        <th>No. Attendants</th>
                        <th>Actions</th>
                    </tr>
                    <?php if (count($meeting_data) == 0) { ?>
                        <tr>
                            <td colspan="4">No Records.</td>
                        </tr>
                    <?php } ?>
                    <?php foreach ($meeting_data as $meeting) { ?>
                        <tr class="table-data">
                            <td>
                                <?= displayValue($meeting->name) ?>
                            </td>
                            <td>
                                <?= displayValue($meeting->date) ?>
                            </td>
                            <td>
                                <?= displayValue($meeting->start_time) ?>
                            </td>
                            <td align="center">
                                <?= displayValue($meeting->participants, 'number') ?>
                            </td>
                            <td align="center">
                                <?= displayValue($meeting->attendance, 'number') ?>
                            </td>
                            <td align="center">
                                <div class="buttons">
                                    <button onclick='onDataPopup("delete-club-meeting", <?= toJson($meeting, ["id"]) ?>)' class="icon-button cl-red">
                                        <span class="material-icons-outlined">
                                            delete
                                        </span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
                <?php $this->view('includes/pagination', [
                    "total_count" => $total_count,
                    "limit" => $limit,
                    "page" => $page
                ]) ?>
            </div>
        </div>
    </section>
</div>

<?php $this->view('includes/models/club/meetings/delete') ?>

<?php $this->view('includes/header/side-bars/club-dashboard', $menu_side_bar) ?>