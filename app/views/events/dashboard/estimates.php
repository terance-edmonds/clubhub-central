<head>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/side-bar.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/dashboard.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/event-dashboard.css">
</head>

<?php $this->view('includes/header') ?>

<!-- alerts -->
<?php $this->view('includes/alerts') ?>

<div id="event-dashboard-budgets" class="container container-sections side-padding event-dashboard dashboard-container">
    <?php $this->view('includes/side-bars/events/dashboard/left', $left_bar) ?>

    <section class="center-section">
        <div class="title-bar">
            <div class="title-wrap">
                <span class="title">Budgets</span>
            </div>

            <div class="budget_buttons">
                <?php if ($club_role === 'TREASURER') { ?>
                    <form method="post">
                        <button <?php if (($event->is_budget_submitted && $event->president_budgets_verified) || ($income_data == 0 || $expense_data == 0)) { ?> disabled <?php } ?> title="Submit event budgets" type="submit" name="submit" value="submit-budgets" class="button w-content" data-variant="contained" data-type="icon" data-size="small">
                            <span><?= $event->is_budget_submitted ? 'Budgets Submitted' : 'Submit Budgets' ?></span>
                            <span class="material-icons-outlined">
                                task_alt
                            </span>
                        </button>
                    </form>
                <?php } ?>

                <?php if ($event->is_budget_submitted) { ?>
                    <?php if ($club_role === 'PRESIDENT') { ?>
                        <form method="post">
                            <button <?php if ($event->president_budgets_verified && $event->incharge_budgets_verified) { ?> disabled <?php } ?> title="Verify event budgets" type="submit" name="submit" value="verify-president-budgets" class="button w-content" data-variant="contained" data-type="icon" data-size="small">
                                <span><?= $event->president_budgets_verified ? 'Budgets Verified' : 'Verify Budgets' ?></span>
                                <span class="material-icons-outlined">
                                    task_alt
                                </span>
                            </button>
                        </form>
                    <?php } ?>
                    <?php if ($club_role === 'PRESIDENT' && (!$event->president_budgets_verified || !$event->incharge_budgets_verified)) { ?>
                        <button onclick='onDataPopup("event-budget-president-reject", <?= toJson($event, ["president_budget_remarks"]) ?>)' title="Verify event budgets" type="button" class="button w-content reject" data-variant="contained" data-type="icon" data-size="small">
                            <span>Reject Budgets</span>
                            <span class="material-icons-outlined">
                                cancel
                            </span>
                        </button>
                    <?php } ?>

                <?php } ?>

                <?php if ($event->is_budget_submitted && $event->president_budgets_verified) { ?>
                    <?php if ($club_role === 'CLUB_IN_CHARGE') { ?>
                        <form method="post">
                            <button <?php if ($event->incharge_budgets_verified) { ?> disabled <?php } ?> title="Verify event budgets" type="submit" name="submit" value="verify-incharge-budgets" class="button w-content" data-variant="contained" data-type="icon" data-size="small">
                                <span><?= $event->incharge_budgets_verified ? 'Budgets Verified' : 'Verify Budgets' ?></span>
                                <span class="material-icons-outlined">
                                    task_alt
                                </span>
                            </button>
                        </form>
                    <?php } ?>
                    <?php if ($club_role === 'CLUB_IN_CHARGE' && !$event->incharge_budgets_verified) { ?>
                        <button onclick='onDataPopup("event-budget-incharge-reject", <?= toJson($event, ["incharge_budget_remarks"]) ?>)' title="Verify event budgets" type="button" class="button w-content reject" data-variant="contained" data-type="icon" data-size="small">
                            <span>Reject Budgets</span>
                            <span class="material-icons-outlined">
                                cancel
                            </span>
                        </button>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>

        <div class="summary-section">
            <?php if ((($club_role === 'TREASURER' || $club_role === 'PRESIDENT') && !$event->president_budgets_verified && !empty($event->president_budget_remarks)) || (($club_role === 'PRESIDENT' || $club_role === 'CLUB_IN_CHARGE') && !$event->incharge_budgets_verified && !empty($event->incharge_budget_remarks))) { ?>
                <p class="title">Remarks</p>

                <?php if (($club_role === 'TREASURER' || $club_role === 'PRESIDENT') && !$event->president_budgets_verified && !empty($event->president_budget_remarks)) { ?>
                    <div class="multi-wrap">
                        <span>Budget Remarks By President: </span>
                        <button title="View Remarks" onclick='onViewPopup("View Remarks", `<?= $event->president_budget_remarks ?>`)' class="icon-button">
                            <span class="material-icons-outlined">
                                visibility
                            </span>
                        </button>
                    </div>
                <?php } ?>

                <?php if (($club_role === 'PRESIDENT' || $club_role === 'CLUB_IN_CHARGE') && !$event->incharge_budgets_verified && !empty($event->incharge_budget_remarks)) { ?>
                    <div class="multi-wrap">
                        <span>Budget Remarks By Club in Charge: </span>
                        <button title="View Remarks" onclick='onViewPopup("View Remarks", `<?= $event->incharge_budget_remarks ?>`)' class="icon-button">
                            <span class="material-icons-outlined">
                                visibility
                            </span>
                        </button>
                    </div>
                <?php } ?>
            <?php } ?>


            <p class="title">Summary</p>

            <div class="cards-section">
                <div class="summary-card">
                    <div class="top-bar">
                        <div class="icon-wrap">
                            <span class="material-icons-outlined">
                                move_to_inbox
                            </span>
                        </div>
                        <p class="card-title">Income</p>
                    </div>

                    <p class="amount green">LKR
                        <?= displayValue($income_data, 'number') ?>
                    </p>
                </div>
                <div class="summary-card">
                    <div class="top-bar">
                        <div class="icon-wrap">
                            <span class="material-icons-outlined">
                                outbox
                            </span>
                        </div>
                        <p class="card-title">Expenses</p>
                    </div>

                    <p class="amount red">LKR
                        <?= displayValue($expense_data, 'number') ?>
                    </p>
                </div>
            </div>
        </div>

        <div class="content-section">
            <div class="actions-wrap">
                <div class="action-buttons">
                    <a class="action-link" data-active="<?php if ($tab == 'income')
                                                            echo 'true'; ?>" href="<?= ROOT ?>/events/dashboard/estimates?tab=income"><button class="button">Income</button></a>
                    <a class="action-link" data-active="<?php if ($tab == 'expense')
                                                            echo 'true'; ?>" href="<?= ROOT ?>/events/dashboard/estimates?tab=expense"><button class="button">Expense</button></a>
                </div>

                <div class="action-search <?php if ($club_role != 'TREASURER') { ?>align-end<?php } ?>">
                    <div class="input-wrap search-input">
                        <div class="input">
                            <span class="icon material-icons-outlined">
                                search
                            </span>
                            <input type="text" placeholder="Search">
                        </div>
                    </div>
                    <?php if ($club_role == 'TREASURER') { ?>
                        <button <?php if ($event->is_budget_submitted && $event->president_budgets_verified && $event->incharge_budgets_verified) { ?> disabled <?php } ?> onclick="$(`[popup-name='add-<?= $tab ?>']`).popup(true)" class="button w-content" data-variant="outlined" data-type="icon" data-size="small">
                            <span>Add New</span>
                            <span class="material-icons-outlined">
                                add
                            </span>
                        </button>
                    <?php } ?>
                    <button onclick="$(`[popup-name='add-<?= $tab ?>']`).popup(true)" class="button w-content" data-variant="outlined" data-type="icon" data-size="small">
                        <span>Add New</span>
                        <span class="material-icons-outlined">
                            add
                        </span>
                    </button>
                </div>
            </div>
            <div class="table-wrap">
                <table>
                    <tr class="table-header">
                        <th>Name</th>
                        <th>Description</th>
                        <th>Amount (LKR)</th>
                        <th>From</th>
                        <th>Payment Type</th>
                        <th>Actions</th>
                    </tr>
                    <?php if (count($table_data) == 0) { ?>
                        <tr>
                            <td colspan="6">No Records.</td>
                        </tr>
                    <?php } ?>
                    <?php foreach ($table_data as $x => $val) {
                    ?>
                        <?php $json = json_encode($val); ?>
                        <tr class="table-data table-align">
                            <td>
                                <?= displayValue($val->name) ?>
                            </td>
                            <td>
                                <?= displayValue($val->description) ?>
                            </td>
                            <td>
                                <?= displayValue($val->amount) ?>
                            </td>
                            <td>
                                <?= displayValue($val->third_party) ?>
                            </td>
                            <td>
                                <?= displayValue($val->payment_type) ?>
                            </td>
                            <td align="center">
                                <div class="buttons">
                                    <?php if ($club_role == 'TREASURER') { ?>
                                        <button onclick='onDataPopup("edit-<?= $tab ?>", <?= $json ?>)' class="icon-button">
                                            <span class="material-icons-outlined">
                                                edit
                                            </span>
                                        </button>
                                    <?php } ?>
                                    <button onclick='onDataPopup("delete-<?= $tab ?>", <?= $json ?>)' class="icon-button cl-red">
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
    $data = ["errors" => $errors];

    $this->view("includes/modals/event/$tab", $data);
    $this->view("includes/modals/event/$tab/edit", $data);
    $this->view("includes/modals/event/$tab/delete");
} ?>

<?php if ($club_role == 'PRESIDENT') {
    $this->view("includes/modals/event/estimates/president-reject");
} ?>
<?php if ($club_role == 'CLUB_IN_CHARGE') {
    $this->view("includes/modals/event/estimates/incharge-reject");
} ?>

<?php $this->view('includes/modals/view-text') ?>

<?php $this->view('includes/header/side-bars/event-dashboard', $menu_side_bar) ?>

<script>
    <?php if (!empty($popups["add-$tab"])) { ?>
        $(`[popup-name='add-<?= $tab ?>']`).popup(true)
    <?php } ?>
    <?php if (!empty($popups["edit-$tab"])) {
        $json = json_encode($popups["edit-$tab"]);
    ?>
        onDataPopup("edit-<?= $tab ?>", <?= $json ?>)
    <?php } ?>
</script>

<script src="<?= ROOT ?>/assets/js/events/event.js"></script>
<script src="<?= ROOT ?>/assets/js/form.js"></script>