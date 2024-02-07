<head>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/side-bar.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/dashboard.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/club-dashboard.css">
</head>

<?php $this->view('includes/header') ?>

<?php $this->view('includes/alerts') ?>

<div id="club-dashboard-event" class="container container-sections side-padding club-dashboard dashboard-container">
    <?php $this->view('includes/side-bars/club/dashboard/left', $left_bar) ?>

    <section class="center-section">
        <div class="title-bar">
            <div class="title-wrap">
                <span class="title">Events</span>
                <?php if ($club_role === 'PRESIDENT' || $club_role === 'CLUB_IN_CHARGE') { ?>
                    <a href="<?= ROOT ?>/club/dashboard/events/add">
                        <button class="button" data-variant="outlined" data-type="icon" data-size="small">
                            <span>Add Event</span>
                            <span class="material-icons-outlined">
                                add
                            </span>
                        </button>
                    </a>
                <?php } ?>
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
        </div>

        <div class="content-section">
            <div class="table-wrap">
                <table>
                    <tr class="table-header">
                        <th>Event Name</th>
                        <th>Start Date & Time</th>
                        <th>End Date & Time</th>
                        <th>Venue</th>
                        <th>Budgets Verified</th>
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
                                <span class="material-icons-outlined <?= $event->is_budgets_verified ? 'cl-green' : 'cl-red' ?>">
                                    <?= $event->is_budgets_verified ? 'task_alt' : 'highlight_off' ?>
                                </span>
                            </td>
                            <td align="center">
                                <a href="<?php echo ($event->state == 'ACTIVE') ? ROOT . '/events/event?id=' . $event->id : 'javascript:void(0);' ?>">
                                    <button <?php if ($event->state != 'ACTIVE') { ?> disabled <?php } ?> class="icon-button">
                                        <span class="material-icons-outlined">
                                            visibility
                                        </span>
                                    </button>
                                </a>
                            </td>
                            <td>
                                <button <?php if ($club_role == 'CLUB_IN_CHARGE' || $club_role == 'PRESIDENT') { ?> onclick='onDataPopup("event-status", <?= toJson($event, ["id", "state"]) ?>)' <?php } ?> class="button status-button <?= ($club_role == 'CLUB_IN_CHARGE' || $club_role == 'PRESIDENT') ? 'pointer-cursor' : '' ?>" data-status="<?= $event->state ?>">
                                    <?= displayValue($event->state, 'start-case') ?>
                                </button>
                            </td>
                            <td align="center">
                                <div class="buttons">
                                    <form method="post">
                                        <input type="text" hidden name="club_event_id" value="<?= $event->id ?>">
                                        <button title="Edit Details" <?php if ($event->state != 'ACTIVE') { ?> disabled <?php } ?> name="submit" value="event-redirect" class="icon-button">
                                            <span class="material-icons-outlined">
                                                edit
                                            </span>
                                        </button>
                                    </form>
                                    <form method="post">
                                        <input type="text" hidden name="club_event_id" value="<?= $event->id ?>">
                                        <button title="Event dashboard" <?php if ($event->state != 'ACTIVE') { ?> disabled <?php } ?> name="submit" value="event-dashboard-redirect" class="icon-button">
                                            <span class="material-icons-outlined">
                                                dashboard
                                            </span>
                                        </button>
                                    </form>
                                    <button title="Delete Event" class="icon-button cl-red">
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

<?php $this->view('includes/modals/event/register') ?>

<?php if ($club_role == 'CLUB_IN_CHARGE' || $club_role == 'PRESIDENT') {
    $this->view('includes/modals/club/events/status');
?>
    <script>
        <?php if (!empty($popups["event-status"])) { ?>
            $(`[popup-name='event-status']`).popup(true)
        <?php } ?>
    </script>
<?php } ?>

<?php $this->view('includes/header/bottom') ?>

<script src="<?= ROOT ?>/assets/js/events/event.js"></script>
<script src="<?= ROOT ?>/assets/js/form.js"></script>