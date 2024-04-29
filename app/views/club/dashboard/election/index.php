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
                <?php if (($club_role == 'CLUB_IN_CHARGE' || $club_role == 'PRESIDENT') && $tab == 'elections') { ?>
                    <a href="<?= ROOT ?>/club/dashboard/election/add">
                        <button class="button" data-variant="outlined" data-type="icon" data-size="small">
                            <span>New Election</span>
                            <span class="material-icons-outlined">
                                add
                            </span>
                        </button>
                    </a>
                <?php } ?>
            </div>

            <form method="get" class="search-input">
                <input type="text" hidden name="tab" value="<?= setValue('tab', '', 'text', 'get') ?>">
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
            <?php if ($club_role == 'CLUB_IN_CHARGE' || $club_role == 'PRESIDENT') { ?>
                <div class="actions-wrap">
                    <div class="action-buttons">
                        <a class="action-link" data-active="<?php if ($tab == 'votes')
                                                                echo 'true'; ?>" href="<?= ROOT ?>/club/dashboard/election?tab=votes"><button class="button">Election Votes</button></a>
                        <a class="action-link" data-active="<?php if ($tab == 'elections')
                                                                echo 'true'; ?>" href="<?= ROOT ?>/club/dashboard/election?tab=elections"><button class="button">Club Elections</button></a>
                    </div>
                </div>
            <?php } ?>

            <?php if ($tab === 'votes') { ?>
                <div class="table-wrap">
                    <table>
                        <tr class="table-header">
                            <th>Title</th>
                            <th>Start Date & Time</th>
                            <th>End Date & Time</th>
                            <th>Description</th>
                            <th>Details</th>
                            <th>Results</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        <?php if (count($election_data) == 0) { ?>
                            <tr>
                                <td colspan="6">No Records.</td>
                            </tr>
                        <?php } ?>
                        <?php foreach ($election_data as $election) { ?>
                            <tr class="table-data">
                                <td><?= displayValue($election->title) ?></td>
                                <td><?= displayValue($election->start_datetime, 'datetime') ?></td>
                                <td><?= displayValue($election->end_datetime, 'datetime') ?></td>
                                <td><?= displayValue($election->description) ?></td>
                                <td align="center">
                                    <a href="<?= ROOT ?>/club/dashboard/election/details?election_id=<?= $election->id ?>">
                                        <button <?php if ($election->state === 'PENDING') { ?> disabled <?php } ?> class="icon-button">
                                            <span class="material-icons-outlined">
                                                visibility
                                            </span>
                                        </button>
                                    </a>
                                </td>
                                <td align="center">
                                    <a href="<?= ROOT ?>/club/dashboard/election/result?club_id=<?= $election->club_id ?>&election_id=<?= $election->id ?>">
                                        <button <?php if ($election->state !== 'CLOSED') { ?> disabled <?php } ?> title="View results" class="icon-button">
                                            <span class="material-icons-outlined">
                                                visibility
                                            </span>
                                        </button>
                                    </a>
                                </td>
                                <td>
                                    <button class="button status-button" data-status="<?= $election->state ?>">
                                        <?= displayValue($election->state, 'start-case') ?>
                                    </button>
                                </td>
                                <td align="center">
                                    <a href="<?= ROOT ?>/club/dashboard/election/vote?election=<?= $election->id ?>">
                                        <button <?php if ($election->state !== 'OPEN') { ?> disabled <?php } ?> title="Vote on election" class="icon-button">
                                            <span class="material-icons-outlined">
                                                how_to_vote
                                            </span>
                                        </button>
                                    </a>
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
            <?php } else if ($tab === 'elections') { ?>
                <div class="table-wrap">
                    <table>
                        <tr class="table-header">
                            <th>Title</th>
                            <th>Start Date & Time</th>
                            <th>End Date & Time</th>
                            <th>Description</th>
                            <th>Details</th>
                            <th>Results</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        <?php if (count($election_data) == 0) { ?>
                            <tr>
                                <td colspan="7">No Records.</td>
                            </tr>
                        <?php } ?>
                        <?php foreach ($election_data as $election) { ?>
                            <tr class="table-data">
                                <td><?= displayValue($election->title) ?></td>
                                <td><?= displayValue($election->start_datetime, 'datetime') ?></td>
                                <td><?= displayValue($election->end_datetime, 'datetime') ?></td>
                                <td><?= displayValue($election->description) ?></td>
                                <td align="center">
                                    <a href="<?= ROOT ?>/club/dashboard/election/details?election_id=<?= $election->id ?>">
                                        <button class="icon-button">
                                            <span class="material-icons-outlined">
                                                visibility
                                            </span>
                                        </button>
                                    </a>
                                </td>
                                <td align="center">
                                    <a href="<?= ROOT ?>/club/dashboard/election/result?club_id=<?= $election->club_id ?>&election_id=<?= $election->id ?>">
                                        <button <?php if ($election->state !== 'OPEN' && $election->state !== 'CLOSED') { ?> disabled <?php } ?> class="icon-button">
                                            <span class="material-icons-outlined">
                                                visibility
                                            </span>
                                        </button>
                                    </a>
                                </td>
                                <td>
                                    <button <?php if ($club_role == 'CLUB_IN_CHARGE') { ?> onclick='onDataPopup("election-status", <?= toJson($election, ["id", "state"]) ?>)' <?php } ?> class="button status-button <?= ($club_role == 'CLUB_IN_CHARGE') ? 'pointer-cursor' : '' ?>" data-status="<?= $election->state ?>">
                                        <?= displayValue($election->state, 'start-case') ?>
                                    </button>
                                </td>
                                <td align="center">
                                    <div class="buttons">
                                        <?php if ($election->state === 'PENDING') { ?>
                                            <a href="<?= ROOT ?>/club/dashboard/election/edit?id=<?= $election->id ?>">
                                                <button class="icon-button">
                                                    <span class="material-icons-outlined">
                                                        edit
                                                    </span>
                                                </button>
                                            </a>
                                        <?php } ?>
                                        <?php if ($club_role == 'CLUB_IN_CHARGE') {  ?>
                                            <button onclick='onDataPopup("delete-election", <?= toJson($election, ["id"]) ?>)' class="icon-button cl-red">
                                                <span class="material-icons-outlined">
                                                    delete
                                                </span>
                                            </button>
                                        <?php } ?>
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
            <?php } ?>
        </div>
    </section>
</div>

<?php if ($club_role == 'CLUB_IN_CHARGE') {
    $this->view('includes/modals/club/election/status');
    $this->view('includes/modals/club/election/delete');
?>
    <!-- on error -->
    <script>
        <?php if (!empty($popups["election-status"])) { ?>
            $(`[popup-name='election-status']`).popup(true)
        <?php } ?>
    </script>
<?php } ?>

<?php $this->view('includes/header/side-bars/club-dashboard', $menu_side_bar) ?>

<script src="<?= ROOT ?>/assets/js/form.js"></script>