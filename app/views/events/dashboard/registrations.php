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
                <span class="title">Registrations</span>
                <button onclick="$(`[popup-name='event-register']`).popup(true)" class="button" data-variant="outlined" data-type="icon" data-size="small">
                    <span>Add New</span>
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

        <form method="post">
            <input type="text" hidden name="form" value="open_registrations_update" />
            <label class="checkbox-label">
                <span>Open Registrations</span>

                <label class="switch">
                    <input <?php if (in_array(setValue('open_registrations'), ['1', 'on'])) { ?> checked <?php } ?> onchange="this.form.submit()" type="checkbox" name="open_registrations">
                    <span class="slider"></span>
                </label>
            </label>
        </form>

        <div class="content-section">
            <div class="table-wrap">
                <table>
                    <tr class="table-header">
                        <th>Full Name</th>
                        <th>Contact No.</th>
                        <th>Email</th>
                        <th>Attendance</th>
                        <th>Actions</th>
                    </tr>
                    <?php foreach ($event_registrations_data as $event_registration) { ?>
                        <tr class="table-data">
                            <td><?= displayValue($event_registration->user_name) ?></td>
                            <td><?= displayValue($event_registration->user_contact) ?></td>
                            <td><?= displayValue($event_registration->user_email) ?></td>
                            <td>
                                <button class="button status-button" data-attended="<?= displayValue($event_registration->attended, 'boolean') ?>">
                                    <?php if ($event_registration->attended == '1') { ?>
                                        Attended
                                    <?php } else { ?>
                                        Pending
                                    <?php } ?>
                                </button>
                            </td>
                            <td align="center">
                                <div class="buttons">
                                    <button onclick='onDataPopup("event-register-update", <?= toJson($event_registration, ["id", "user_name", "user_email", "user_contact"]) ?>)' class="icon-button">
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

<?php $this->view('includes/modals/event/register', ["errors" => $errors]) ?>
<?php $this->view('includes/modals/event/register/update', ["errors" => $errors]) ?>

<script src="<?= ROOT ?>/assets/js/form.js"></script>

<script>
    <?php if (!empty($popups["event-register"])) { ?>
        $(`[popup-name='event-register']`).popup(true)
    <?php } ?>
    <?php if (!empty($popups["event-register-update"])) { ?>
        $(`[popup-name='event-register-update']`).popup(true)
    <?php } ?>
</script>