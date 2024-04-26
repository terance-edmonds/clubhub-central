<head>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/side-bar.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/dashboard.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/admin-dashboard.css">
</head>

<?php $this->view('includes/header') ?>

<!-- alerts -->
<?php $this->view('includes/alerts') ?>

<div id="admin-dashboard-clubs" class="container container-sections side-padding admin-dashboard dashboard-container">
    <?php $this->view('includes/side-bars/admin/left', ["menu" => $menu]) ?>

    <section class="center-section">
        <div class="title-bar">
            <div class="title-wrap">
                <span class="title">Clubs</span>
                <a href="<?= ROOT ?>/admin/dashboard/club/add">
                    <button class="button" data-variant="outlined" data-type="icon" data-size="small">
                        <span>Add Club</span>
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
                        <th>Club Name</th>
                        <th>Club In-Charge</th>
                        <th>Created Date & Time</th>
                        <th>Status</th>
                        <th>View</th>
                        <th>Actions</th>
                    </tr>
                    <?php if (count($table_data) == 0) { ?>
                        <tr>
                            <td colspan="6">No Records.</td>
                        </tr>
                    <?php } ?>
                    <?php foreach ($table_data as $x => $val) {
                    ?>
                        <tr class="table-data">
                            <td>
                                <?= displayValue($val->name) ?>
                            </td>
                            <td>
                                <?= displayValue($val->club_in_charge_email) ?>
                            </td>
                            <td>
                                <?= displayValue($val->created_datetime, 'datetime') ?>
                            </td>
                            <td>
                                <button class="button status-button" data-status="<?= $val->state ?>">
                                    <?= displayValue($val->state, 'start-case') ?>
                                </button>
                            </td>
                            <td align="center">
                                <a href="<?php echo ($val->state == 'ACTIVE') ? ROOT . '/club?id=' . $val->id : 'javascript:void(0);' ?>">
                                    <button <?php if ($val->state === 'DEACTIVE') { ?> disabled <?php } ?> class="icon-button">
                                        <span class="material-icons-outlined">
                                            visibility
                                        </span>
                                    </button>
                                </a>
                            </td>
                            <td align="center">
                                <div class="buttons">
                                    <button onclick='onDataPopup("delete-club", <?= toJson($val, ["id"]) ?>)' class="icon-button cl-red">
                                        <span class="material-icons-outlined">
                                            delete
                                        </span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
                <?php
                $this->view('includes/pagination', [
                    "total_count" => $total_count,
                    "limit" => $limit,
                    "page" => $page
                ]); ?>
            </div>
        </div>
    </section>
</div>

<?php $this->view('includes/modals/admin/club/delete') ?>

<?php $this->view('includes/header/bottom') ?>

<script src="<?= ROOT ?>/assets/js/form.js"></script>