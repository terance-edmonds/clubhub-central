<head>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/side-bar.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/dashboard.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/event-dashboard.css">
</head>

<?php $this->view('includes/header') ?>

<!-- alerts -->
<?php $this->view('includes/alerts') ?>

<div id="event-dashboard-registrations" class="container container-sections side-padding event-dashboard dashboard-container">
    <?php $this->view('includes/side-bars/events/dashboard/left', ["menu" => $menu])  ?>

    <section class="center-section">
        <div class="title-bar">
            <div class="title-wrap">
                <span class="title">Agenda</span>
                <button onclick="$(`[popup-name='add-agenda']`).popup(true)" class="button" data-variant="outlined" data-type="icon" data-size="small">
                    <span>Add New</span>
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
                        <input type="text" placeholder="Search" name="search" value="<?= setValue('search', '', 'text', 'get') ?>">
                    </div>
                </div>
            </form>

            <div class="content-section">
                <div class="table-wrap">
                    <table>
                        <tr class="table-header">
                            <th>Name</th>
                            <th>Date & Time</th>
                            <th>Location</th>
                            <th>Note</th>
                            <th>Actions</th>
                        </tr>
                        <?php if (count($agenda_data) == 0) { ?>
                            <tr>
                                <td colspan="5">No Records.</td>
                            </tr>
                        <?php } ?>
                        <?php foreach ($agenda_data as $agenda) { ?>
                            <tr class="table-data">
                                <td><?= displayValue($agenda->name) ?></td>
                                <td><?= displayValue($agenda->datetime, 'datetime') ?></td>
                                <td><?= displayValue($agenda->venue) ?></td>
                                <td><?= displayValue($agenda->note) ?></td>
                                <td align="center">
                                    <div class="buttons">
                                        <button title="Edit Details" onclick='onDataPopup("edit-agenda", <?= toJson($agenda, ["id", "name", "datetime", "venue", "note"]) ?>)' class="icon-button">
                                            <span class="material-icons-outlined">
                                                edit
                                            </span>
                                        </button>
                                        <button title="Delete Record" onclick='onDataPopup("delete-agenda", <?= toJson($agenda, ["id"]) ?>)' class="icon-button cl-red">
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

<?php $this->view('includes/modals/event/agenda') ?>
<?php $this->view('includes/modals/event/agenda/edit') ?>
<?php $this->view('includes/modals/event/agenda/delete') ?>

<script>
    <?php if (!empty($popups["add-agenda"])) { ?>
        $(`[popup-name='add-agenda']`).popup(true)
    <?php } ?>
    <?php if (!empty($popups["edit-agenda"])) { ?>
        $(`[popup-name='edit-agenda']`).popup(true)
    <?php } ?>
</script>

<script src="<?= ROOT ?>/assets/js/form.js"></script>
<script src="<?= ROOT ?>/assets/js/events/agenda.js"></script>