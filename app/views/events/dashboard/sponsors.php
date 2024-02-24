<head>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/side-bar.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/dashboard.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/event-dashboard.css">
</head>

<?php $this->view('includes/header') ?>
<?php $this->view('includes/alerts') ?>

<div id="event-dashboard-sponsors" class="container container-sections side-padding event-dashboard dashboard-container">
    <?php $this->view('includes/side-bars/events/dashboard/left', $left_bar)  ?>

    <section class="center-section">
        <div class="title-bar">
            <div class="title-wrap">
                <span class="title">Packages</span>
                <button onclick="$(`[popup-name='add-package']`).popup(true);" class="button" data-variant="outlined" data-type="icon" data-size="small">
                    <span>Add Package</span>
                    <span class="material-icons-outlined">
                        add
                    </span>
                </button>
            </div>
            <form method="get" class="search-input">
                <div class="input-wrap">
                    <div class="input">
                        <button type="submit" class="icon-button">
                            <span class="icon material-icons-outlined">
                                search
                            </span>
                        </button>
                        <input type="text" placeholder="Search" name="packages_search" value="<?= setValue('packages_search', '', 'text', 'get') ?>">
                    </div>
                </div>
            </form>
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
                <?php $this->view('includes/pagination', [
                    "total_count" => $total_packages_count,
                    "limit" => $packages_limit,
                    "page" => $packages_page,
                    "script_included" => true,
                    "page_name" => "package_page"
                ]) ?>
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
            <form method="get" class="search-input">
                <div class="input-wrap">
                    <div class="input">
                        <button type="submit" class="icon-button">
                            <span class="icon material-icons-outlined">
                                search
                            </span>
                        </button>
                        <input type="text" placeholder="Search" name="sponsors_search" value="<?= setValue('sponsors_search', '', 'text', 'get') ?>">
                    </div>
                </div>
            </form>
        </div>

        <div class="content-section">
            <div class="table-wrap">
                <table>
                    <tr class="table-header">
                        <th>Sponsor Name</th>
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
                            <td align="center">
                                <div class="buttons">
                                    <button onclick='onDataPopup("edit-sponsor", <?= $json ?>)' class="icon-button">
                                        <span class="material-icons-outlined">
                                            edit
                                        </span>
                                    </button>
                                    <button onclick='onDataPopup("delete-sponsor", <?= $json ?>)' class="icon-button cl-red">
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
                    "total_count" => $total_sponsors_count,
                    "limit" => $sponsors_limit,
                    "page" => $sponsors_page,
                    "script_included" => true,
                    "page_name" => "sponsor_page"
                ]) ?>
            </div>
        </div>
    </section>
</div>

<?php $this->view('includes/modals/event/package') ?>
<?php $this->view('includes/modals/event/package/edit') ?>
<?php $this->view('includes/modals/event/package/delete') ?>

<?php $this->view('includes/modals/event/sponsor') ?>
<?php $this->view('includes/modals/event/sponsor/edit') ?>
<?php $this->view('includes/modals/event/sponsor/delete') ?>

<?php $this->view('includes/header/side-bars/event-dashboard', $menu_side_bar) ?>

<script>
    <?php if (!empty($popups["add-package"])) { ?>
        $(`[popup-name='add-package']`).popup(true)
    <?php } ?>
    <?php if (!empty($popups["edit-package"])) { ?>
        $(`[popup-name='edit-package']`).popup(true)
    <?php } ?>
</script>

<script>
    <?php if (!empty($popups["add-sponsor"])) { ?>
        $(`[popup-name='add-sponsor']`).popup(true)
    <?php } ?>
    <?php if (!empty($popups["edit-sponsor"])) { ?>
        $(`[popup-name='edit-sponsor']`).popup(true)
    <?php } ?>
</script>

<script src="<?= ROOT ?>/assets/js/events/event.js"></script>
<script src="<?= ROOT ?>/assets/js/form.js"></script>
<script src="<?= ROOT ?>/assets/js/pagination.js"></script>