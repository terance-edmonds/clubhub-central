<head>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/side-bar.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/dashboard.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/club-dashboard.css">
</head>

<?php $this->view('includes/header') ?>

<div id="club-dashboard-event" class="container container-sections side-padding club-dashboard dashboard-container">
    <?php $this->view('includes/side-bars/club/dashboard/left', ["menu" => $menu]) ?>

    <section class="center-section">
        <div class="title-bar">
            <div class="title-wrap">
                <span class="title">Events</span>
                <a href="<?= ROOT ?>/club/dashboard/events/add">
                    <button class="button" data-variant="outlined" data-type="icon" data-size="small">
                        <span>Add Event</span>
                        <span class="material-icons-outlined">
                            add
                        </span>
                    </button>
                </a>
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
                        <th>Start Date & Time</th>
                        <th>End Date & Time</th>
                        <th>Venue</th>
                        <th>View</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    <?php foreach ($events_data as $event) { ?>
                        <tr class="table-data">
                            <td>
                                <?= displayValue($event->name) ?>
                            </td>
                            <td>
                                <?= displayValue($event->start_datetime, 'datetime') ?>
                            </td>
                            <td>
                                <?= displayValue($event->end_datetime, 'datetime') ?>
                            </td>
                            <td>
                                <?= displayValue($event->venue) ?>
                            </td>
                            <td align="center">
                                <a
                                    href="<?php echo ($event->state == 'ACTIVE') ? ROOT . '/events/event?id=' . $event->id : 'javascript:void(0);' ?>">
                                    <button <?php if ($event->state != 'ACTIVE') { ?> disabled <?php } ?>
                                        class="icon-button">
                                        <span class="material-icons-outlined">
                                            visibility
                                        </span>
                                    </button>
                                </a>
                            </td>
                            <td>
                                <button class="button status-button" data-status="<?= $event->state ?>">
                                    <?= displayValue($event->state, 'start-case') ?>
                                </button>
                            </td>
                            <td align="center">
                                <div class="buttons">
                                    <form method="post">
                                        <input type="text" hidden name="club_event_id" value="<?= $event->id ?>">
                                        <button <?php if ($event->state != 'ACTIVE') { ?> disabled <?php } ?> name="submit"
                                            value="event-redirect" class="icon-button">
                                            <span class="material-icons-outlined">
                                                edit
                                            </span>
                                        </button>
                                    </form>
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