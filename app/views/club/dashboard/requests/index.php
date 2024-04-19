<head>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/side-bar.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/dashboard.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/club-dashboard.css">
</head>

<?php $this->view('includes/header') ?>

<?php $this->view('includes/alerts') ?>

<div id="club-dashboard-requests" class="container container-sections side-padding club-dashboard dashboard-container">
    <?php $this->view('includes/side-bars/club/dashboard/left', $left_bar) ?>

    <section class="center-section">
        <div class="title-bar">
            <div class="title-wrap">
                <span class="title">Requests</span>
                <a href="<?= ROOT ?>/club/dashboard/requests/add">
                    <button class="button" data-variant="outlined" data-type="icon" data-size="small">
                        <span>New Request</span>
                        <span class="material-icons-outlined">
                            add
                        </span>
                    </button>
                </a>
            </div>

            <form method="get" class="search-input">
                <div class="input-wrap">
                    <div class="input">
                        <button type="submit" class="icon-button">
                            <span class="icon material-icons-outlined">
                                search
                            </span>
                        </button>
                        <input type="text" placeholder="Search" name="search" value="<?= setValue('search', '', 'text', 'get') ?>">
                    </div>
                </div>
            </form>
        </div>

        <div class="content-section">
            <div class="table-wrap">
                <table>
                    <tr class="table-header">
                        <th>ID</th>
                        <th>Subject</th>
                        <th>Created Date & Time</th>
                        <th>Event Name</th>
                        <th>Event Date & Time</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Remarks</th>
                        <th>Actions</th>
                    </tr>
                    <tr class="table-data">
                        <?php if (count($table_data) == 0) { ?>
                            <td colspan="8">No Records.</td>
                    </tr>
                <?php } ?>
                <?php foreach ($table_data as $x => $val) { ?>
                    <tr>
                        <td><?= displayValue($val->id) ?></td>
                        <td><?= displayValue($val->subject) ?></td>
                        <td><?= displayValue($val->created_datetime, 'datetime') ?></td>
                        <td><?= displayValue($val->event_name) ?></td>
                        <td><?= displayValue($val->event_date, 'datetime') ?></td>
                        <td align="center">
                            <button class="icon-button" onclick='onViewPopup("View Description", `<?= $val->description ?>`)'>
                                <span class="material-icons-outlined">
                                    visibility
                                </span>
                            </button>
                        </td>
                        <td>
                            <button class="button status-button" data-status="<?= $val->state ?>">
                                <?= displayValue($val->state, 'start-case') ?>
                            </button>
                        </td>
                        <td align="center">
                            <button class="icon-button" onclick='onViewPopup("View Remarks", `<?= $val->remarks ? $val->remarks : "No remarks." ?>`)'>
                                <span class="material-icons-outlined">
                                    visibility
                                </span>
                            </button>
                        </td>
                        <td align="center">
                            <div class="buttons">
                                <a href="<?php echo ($val->state != 'APPROVED') ? ROOT . '/club/dashboard/requests/edit?id=' . $val->id : 'javascript:void(0);' ?>">
                                    <button <?php if ($val->state == 'APPROVED') { ?> disabled <?php } ?> class="icon-button">
                                        <span class="material-icons-outlined">
                                            edit
                                        </span>
                                    </button>
                                </a>
                                <button <?php if ($val->state == 'APPROVED') { ?> disabled <?php } ?> onclick='onDataPopup("delete-club-request", <?= toJson($val, ["id"]) ?>)' class="icon-button cl-red">
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

<?php $this->view('includes/modals/view-text') ?>
<?php $this->view('includes/modals/club/request/delete') ?>
<?php $this->view('includes/modals/event/register') ?>
<?php $this->view('includes/header/side-bars/club-dashboard', $menu_side_bar) ?>

<script src="<?= ROOT ?>/assets/js/events/event.js"></script>
<script src="<?= ROOT ?>/assets/js/form.js"></script>