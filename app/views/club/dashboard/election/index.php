<head>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/side-bar.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/dashboard.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/club-dashboard.css">
</head>

<?php $this->view('includes/header') ?>

<?php $this->view('includes/alerts') ?>

<div id="club-dashboard-election" class="container container-sections side-padding club-dashboard dashboard-container">
    <?php $this->view('includes/side-bars/club/dashboard/left', $left_bar) ?>

    <section class="center-section">
        <div class="title-bar">
            <div class="title-wrap">
                <span class="title">Elections</span>
                <a href="<?= ROOT ?>/club/dashboard/election/add">
                    <button class="button" data-variant="outlined" data-type="icon" data-size="small">
                        <span>New Election</span>
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
                        <th>Title</th>
                        <th>Start Date & Time</th>
                        <th>End Date & Time</th>
                        <th>Description</th>
                        <th>View</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    <?php foreach ($election_data as $election) { ?>
                        <tr class="table-data">
                            <td><?= displayValue($election->title) ?></td>
                            <td><?= displayValue($election->start_datetime, 'datetime') ?></td>
                            <td><?= displayValue($election->end_datetime, 'datetime') ?></td>
                            <td><?= displayValue($election->description) ?></td>
                            <td align="center">
                                <button class="icon-button">
                                    <span class="material-icons-outlined">
                                        visibility
                                    </span>
                                </button>
                            </td>
                            <td>
                                <button <?php if ($club_role == 'CLUB_IN_CHARGE') { ?> onclick='onDataPopup("election-status", <?= toJson($election, ["id", "state"]) ?>)' <?php } ?> class="button status-button <?= ($club_role == 'CLUB_IN_CHARGE') ? 'pointer-cursor' : '' ?>" data-status="<?= $election->state ?>">
                                    <?= displayValue($election->state, 'start-case') ?>
                                </button>
                            </td>
                            <td align="center">
                                <div class="buttons">
                                    <a href="<?= ROOT ?>/club/dashboard/election/edit?id=<?= $election->id ?>">
                                        <button class="icon-button">
                                            <span class="material-icons-outlined">
                                                edit
                                            </span>
                                        </button>
                                    </a>
                                    <?php if ($club_role == 'CLUB_IN_CHARGE') {  ?>
                                        <button onclick='onDataPopup("delete-election", <?= toJson($election, ["id"]) ?>)' class="icon-button cl-red">
                                            <span class="material-icons-outlined">
                                                delete
                                            </span>
                                        </button>
                                    <?php } ?>
                                    <button onclick='onDataPopup("delete-election", <?= toJson($election, ["id"]) ?>)' class="icon-button cl-red">
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

<?php if ($club_role == 'CLUB_IN_CHARGE') {
    $this->view('includes/modals/club/election/status');
    $this->view('includes/modals/club/election/delete');
?>
    <script>
        <?php if (!empty($popups["election-status"])) { ?>
            $(`[popup-name='election-status']`).popup(true)
        <?php } ?>
    </script>
<?php } ?>

<?php $this->view('includes/modals/club/election/delete'); ?>

<?php $this->view('includes/header/side-bars/club-dashboard', $menu_side_bar) ?>
<?php $this->view('includes/modals/event/register') ?>

<script src="<?= ROOT ?>/assets/js/form.js"></script>
<script src="<?= ROOT ?>/assets/js/events/event.js"></script>