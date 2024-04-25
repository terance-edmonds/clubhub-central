<head>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/side-bar.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/dashboard.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/event-dashboard.css">
</head>

<?php $this->view('includes/header') ?>

<!-- alerts -->
<?php $this->view('includes/alerts') ?>

<div id="event-dashboard-registrations" class="container container-sections side-padding event-dashboard dashboard-container">
    <?php $this->view('includes/side-bars/events/dashboard/left', $left_bar) ?>

    <section class="center-section">
        <div class="title-bar">
            <div class="title-wrap">
                <span class="title">Complains</span>
            </div>
        </div>

        <div class="content-section">
            <div class="table-wrap">
                <table>
                    <tr class="table-header">
                        <th>ID</th>
                        <th>Complain</th>
                        <th>Actions</th>
                    </tr>
                    <?php if (count($complains_data) == 0) { ?>
                        <tr>
                            <td colspan="4">No Records.</td>
                        </tr>
                    <?php } ?>
                    <?php foreach ($complains_data as $complain) { ?>
                        <tr class="table-data">
                            <td align="center">
                                <?= displayValue($complain->id) ?>
                            </td>
                            <td align="center">
                                <button class="icon-button" onclick='onViewPopup("View Complain", `<?= $complain->complain ?>`)'>
                                    <span class="material-icons-outlined">
                                        visibility
                                    </span>
                                </button>
                            </td>
                            <td align="center">
                                <button onclick='onDataPopup("delete-complain", <?= toJson($complain, ["id"]) ?>)' title="Delete Record" class="icon-button cl-red">
                                    <span class="material-icons-outlined">
                                        delete
                                    </span>
                                </button>
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
<?php $this->view('includes/header/side-bars/event-dashboard', $menu_side_bar) ?>
<?php $this->view('includes/modals/event/complain/delete') ?>

<script src="<?= ROOT ?>/assets/js/form.js"></script>