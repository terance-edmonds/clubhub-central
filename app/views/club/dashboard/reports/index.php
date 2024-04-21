<head>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/side-bar.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/dashboard.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/club-dashboard.css">
</head>

<?php $this->view('includes/header') ?>

<?php $this->view('includes/alerts') ?>

<div id="club-dashboard-reports" class="container container-sections side-padding club-dashboard dashboard-container">
    <?php $this->view('includes/side-bars/club/dashboard/left', $left_bar) ?>

    <section class="center-section">
        <div class="title-bar">
            <div class="title-wrap">
                <span class="title">Reports</span>
                <a href="<?= ROOT ?>/club/dashboard/reports/add">
                    <button class="button" data-variant="outlined" data-type="icon" data-size="small">
                        <span>New Report</span>
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
                        <th>Report Name</th>
                        <th>Report Type</th>
                        <th>Start Date & Time</th>
                        <th>End Date & Time</th>
                        <th>Created By</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                    <?php if (count($table_data) == 0) { ?>
                        <tr>
                            <td colspan="7">No Records.</td>
                        </tr>
                    <?php } ?>
                    <?php foreach ($table_data as $key => $value) { ?>
                        <tr class="table-data">
                            <td><?= displayValue($value->report_name) ?></td>
                            <td><?= displayValue($value->report_type) ?></td>
                            <td><?= $value->start_datetime ? displayValue($value->start_datetime) : '-' ?></td>
                            <td><?= $value->end_datetime ? displayValue($value->end_datetime) : '-' ?></td>
                            <td><?= $value->user_name ?></td>
                            <td align="center">
                                <script>
                                    document.write(moment('<?= $value->created_datetime ?>').tz(Intl.DateTimeFormat().resolvedOptions().timeZone).format('yyyy-MM-DD'));
                                </script>
                            </td>
                            <td align="center">
                                <div class="buttons">
                                    <a href="<?= $value->report_link ?>">
                                        <button class="icon-button">
                                            <span class="material-icons-outlined">
                                                cloud_download
                                            </span>
                                        </button>
                                    </a>

                                    <button onclick='onDataPopup("delete-club-report", <?= toJson($value, ["id"]) ?>)' class="icon-button cl-red">
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
                    "page" => $page,
                ]) ?>
            </div>
        </div>
    </section>
</div>

<?php $this->view('includes/modals/club/report/delete') ?>

<?php $this->view('includes/header/side-bars/club-dashboard', $menu_side_bar) ?>

<script src="<?= ROOT ?>/assets/js/form.js"></script>