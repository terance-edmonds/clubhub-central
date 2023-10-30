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
                <button onclick="$(`[popup-name='event-add-agenda']`).popup(true)" class="button" data-variant="outlined" data-type="icon" data-size="small">
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

            <div class="content-section">
                <div class="table-wrap">
                    <table>
                        <tr class="table-header">
                            <th>Date & Time</th>
                            <th>Name</th>
                            <th>Location</th>
                            <th>Actions</th>
                        </tr>
                        <tr class="table-data">
                            <td>11/04/23 - 10.00 AM</td>
                            <td>Welcome & Introduction</td>
                            <td>-</td>
                            <td align="center">
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
                    </table>
                </div>
            </div>
    </section>
</div>

<?php $this->view('includes/modals/event/agenda') ?>