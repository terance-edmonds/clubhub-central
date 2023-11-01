<head>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/side-bar.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/dashboard.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/event-dashboard.css">
</head>

<?php $this->view('includes/header') ?>
<?php $this->view('includes/alerts') ?>

<div id="event-dashboard-sponsors" class="container container-sections side-padding event-dashboard dashboard-container">
    <?php $this->view('includes/side-bars/events/dashboard/left', ["menu" => $menu])  ?>

    <section class="center-section">
        <div class="title-bar">
            <div class="title-wrap">
                <span class="title">Packages</span>
                <button onclick="addPackage(event)" class="button" data-variant="outlined" data-type="icon" data-size="small">
                    <span>Add Package</span>
                    <span class="material-icons-outlined">
                        add
                    </span>
                </button>
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

        <div class="content-section">
            <div class="table-wrap">
                <table>
                    <tr class="table-header">
                        <th align="left">Package Name</th>
                        <th align="left">Amount</th>
                        <th align="left">Actions</th>
                    </tr>
                    <?php if (count($packages_data) == 0) { ?>
                        <tr>
                            <td colspan="6">No Records.</td>
                        </tr>
                    <?php } ?>
                    <?php foreach ($packages_data as $x => $val) {
                    ?>
                        <?php $json = json_encode($val); ?>
                        <tr class="table-data table-align">
                            <td><?= displayValue($val->name) ?></td>
                            <td><?= displayValue($val->amount) ?></td>
                            <td>
                                <div class="buttons">
                                    <button onclick='onDataPopup("edit-package", <?= $json ?>)' class="icon-button">
                                        <span class="material-icons-outlined">
                                            edit
                                        </span>
                                    </button>
                                    <button onclick='onDataPopup("delete-package", <?= $json ?>)' class="icon-button cl-red">
                                        <span class="material-icons-outlined">
                                            delete
                                        </span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>

        <div class="title-bar">
            <div class="title-wrap">
                <span class="title">Sponsors</span>
                <button onclick="$(`[popup-name='add-sponsor']`).popup(true)" class="button contained" class="button" data-variant="outlined" data-type="icon" data-size="small">
                    <span>Add Sponsor</span>
                    <span class="material-icons-outlined">
                        add
                    </span>
                </button>
            </div>
        </div>

        <div class="content-section">
            <div class="table-wrap">
                <table>
                    <tr class="table-header">
                        <th>Sponser Name</th>
                        <th>Contact Person</th>
                        <th>Contact No</th>
                        <th>Email</th>
                        <th>Amount</th>
                        <th>Actions</th>
                    </tr>
                    <?php if (count($sponsors_data) == 0) { ?>
                        <tr>
                            <td colspan="6">No Records.</td>
                        </tr>
                    <?php } ?>
                    <?php foreach ($sponsors_data as $x => $val) {
                    ?>
                        <?php $json = json_encode($val); ?>
                        <tr class="table-data table-align">
                            <td><?= displayValue($val->name) ?></td>
                            <td><?= displayValue($val->contact_person) ?></td>
                            <td><?= displayValue($val->contact_number) ?></td>
                            <td><?= displayValue($val->email) ?></td>
                            <td><?= displayValue($val->amount) ?></td>
                            <td>
                                <div class="buttons">
                                    <button class="icon-button">
                                        <span class="material-icons-outlined">
                                            edit
                                        </span>
                                    </button>
                                    <button class="icon-button cl-red">
                                        <span class="material-icons-outlined">
                                            delete
                                        </span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </section>
</div>




<script>
    <?php if (!empty($popups["add-sponsor"])) { ?>
        $(`[popup-name='add-sponsor']`).popup(true)
    <?php } ?>
    <?php if (!empty($popups["edit-sponsor"])) {
        $json = json_encode($popups["edit-sponsor"]);
    ?>
        onDataPopup("edit-sponsor", <?= $json ?>)
    <?php } ?>
</script>

<script>
    <?php if (!empty($popups["add-package"])) { ?>
        $(`[popup-name='add-package']`).popup(true)
    <?php } ?>
    <?php if (!empty($popups["edit-package"])) {
        $json = json_encode($popups["edit-pacakge"]);
    ?>
        onDataPopup("edit-package", <?= $json ?>)
    <?php } ?>
</script>


<script src="<?= ROOT ?>/assets/js/events/event.js"></script>
<script src="<?= ROOT ?>/assets/js/events/sponsor.js"></script>

<?php $this->view('includes/modals/event/sponsor') ?>
<?php $this->view('includes/modals/event/sponsor/edit') ?>
<?php $this->view('includes/modals/event/sponsor/delete') ?>

<?php $this->view('includes/modals/event/package') ?>
<?php $this->view('includes/modals/event/package/edit') ?>
<?php $this->view('includes/modals/event/package/delete') ?>