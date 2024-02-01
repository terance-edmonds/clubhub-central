<head>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/side-bar.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/dashboard.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/admin-dashboard.css">
</head>

<?php $this->view('includes/header') ?>

<div id="admin-dashboard-events" class="container container-sections side-padding admin-dashboard dashboard-container">
    <?php $this->view('includes/side-bars/admin/left', ["menu" => $menu]) ?>

    <section class="center-section">
        <div class="title-bar">
            <div class="title-wrap">
                <span class="title">Events</span>
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
                        <th>Event Name</th>
                        <th>Club Name</th>
                        <th>Date & Time</th>
                        <th>Venue</th>
                        <th>View</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>

                    <?php if (count($events_data) == 0) { ?>
                        <tr>
                            <td colspan="7">No Records.</td>
                        </tr>
                    <?php } ?>

                    <?php foreach ($events_data as $event) { ?>
                        <tr class="table-data">
                            <td>
                                <?= displayValue($event->name) ?>
                            </td>
                            <td>
                                <?= displayValue($event->club_name) ?>
                            </td>
                            <td>
                                <?= displayValue($event->start_datetime) ?>
                            </td>
                            <td>
                                <?= displayValue($event->venue) ?>
                            </td>
                            <td align="center">
                                <button class="icon-button">
                                    <span class="material-icons-outlined">
                                        visibility
                                    </span>
                                </button>
                            </td>
                            <td>
                                <button class="button status-button" data-status="PENDING">
                                    Pending
                                </button>
                            </td>
                            <td align="center">
                                <div class="buttons">
                                    <a href="<?= ROOT ?>/events/dashboard">
                                        <button class="icon-button">
                                            <span class="material-icons-outlined">
                                                edit
                                            </span>
                                        </button>
                                    </a>
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

<?php $this->view('includes/modals/event/register') ?>
<script src="<?= ROOT ?>/assets/js/events/event.js"></script>

<?php $this->view('includes/header/bottom') ?>