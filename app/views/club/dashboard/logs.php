<head>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/cards.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/side-bar.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/dashboard.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/club-dashboard.css">
</head>

<?php $this->view('includes/header') ?>

<div id="club-dashboard-logs" class="container container-sections side-padding club-dashboard dashboard-container">
    <?php $this->view('includes/side-bars/club/dashboard/left', $left_bar) ?>

    <section class="center-section">
        <div class="title-bar">
            <div class="title-wrap">
                <span class="title">Logs</span>
            </div>

            <form method="get" class="search-input">
                <div class="input-wrap">
                    <div class="input">
                        <button type="submit" class="icon-button">
                            <span class="icon material-icons-outlined">
                                search
                            </span>
                        </button>
                        <input type="text" hidden name="tab" value="<?= setValue('tab', 'posts', 'text', 'get') ?>">
                        <input type="text" placeholder="Search" name="search" value="<?= setValue('search', '', 'text', 'get') ?>">
                    </div>
                </div>
            </form>
        </div>

        <?php if ($tab == 'posts') { ?>
            <div class="content-section">
                <div class="action-buttons">
                    <a class="action-link" data-active="<?php if ($tab == 'posts')
                                                            echo 'true'; ?>" href="<?= ROOT ?>/club/dashboard/logs?tab=posts"><button class="button">Posts</button></a>
                    <a class="action-link" data-active="<?php if ($tab == 'budgets')
                                                            echo 'true'; ?>" href="<?= ROOT ?>/club/dashboard/logs?tab=budgets"><button class="button">Budgets</button></a>
                </div>
                <div class="table-wrap">
                    <table>
                        <tr class="table-header">
                            <th>Users' name</th>
                            <th>Email</th>
                            <th>Post Name</th>
                            <th>Action</th>
                            <th>View</th>
                            <th>Created Date & Time</th>
                            <th>Updated Date & Time</th>
                        </tr>
                        <?php foreach ($table_data as $x => $val) {
                        ?>
                            <tr class="table-data">
                                <td>
                                    <?= displayValue($val->first_name) ?> <?= displayValue($val->last_name) ?>
                                </td>
                                <td>
                                    <?= displayValue($val->email) ?>
                                </td>
                                <td>
                                    <?= displayValue($val->post_name) ?>
                                </td>
                                <td>
                                    <?= displayValue($val->log_description) ?>
                                </td>
                                <td align="center">
                                    <button onclick='onViewPost(<?= toJson($val, ["post_name", "club_name", "club_image", "image", "description", "club_id", "created_datetime"]) ?>)' class="icon-button">
                                        <span class="material-icons-outlined">
                                            visibility
                                        </span>
                                    </button>
                                </td>
                                <td>
                                    <?= displayValue($val->created_at, 'datetime') ?>
                                </td>
                                <td>
                                    <?= displayValue($val->updated_at, 'datetime') ?>
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
        <?php } else if ($tab == 'budgets') { ?>
            <div class="content-section">
                <div class="action-buttons">
                    <a class="action-link" data-active="<?php if ($tab == 'posts')
                                                            echo 'true'; ?>" href="<?= ROOT ?>/club/dashboard/logs?tab=posts"><button class="button">Posts</button></a>
                    <a class="action-link" data-active="<?php if ($tab == 'budgets')
                                                            echo 'true'; ?>" href="<?= ROOT ?>/club/dashboard/logs?tab=budgets"><button class="button">Budgets</button></a>
                </div>
                <div class="table-wrap">
                    <table>
                        <tr class="table-header">
                            <th>Users' name</th>
                            <th>Email</th>
                            <th>Event Name</th>
                            <th>Budget Name</th>
                            <th>Budget Type</th>
                            <th>Action</th>
                            <th>Created Date & Time</th>
                            <th>Updated Date & Time</th>
                        </tr>
                        <?php foreach ($table_data as $x => $val) {
                        ?>
                            <tr class="table-data">
                                <td>
                                    <?= displayValue($val->first_name) ?> <?= displayValue($val->last_name) ?>
                                </td>
                                <td>
                                    <?= displayValue($val->email) ?>
                                </td>
                                <td>
                                    <?= displayValue($val->event_name) ?>
                                </td>
                                <td>
                                    <?= displayValue($val->budget_name) ?>
                                </td>
                                <td align="center">
                                    <?= displayValue($val->type) ?>
                                </td>
                                <td>
                                    <?= displayValue($val->description) ?>
                                </td>
                                <td>
                                    <?= displayValue($val->created_at, 'datetime') ?>
                                </td>
                                <td>
                                    <?= displayValue($val->updated_at, 'datetime') ?>
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
        <?php } ?>
    </section>
</div>

<?php $this->view('includes/header/side-bars/club-dashboard', $menu_side_bar) ?>
<?php $this->view('includes/modals/club/post') ?>
<?php $this->view('includes/header/bottom') ?>

<!-- club post view -->
<script src="<?= ROOT ?>/assets/js/club/dashboard/view-post.js"></script>