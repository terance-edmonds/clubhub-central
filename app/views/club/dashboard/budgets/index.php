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
                <span class="title">Event Budgets</span>
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
                                <form method="post">
                                    <input type="text" hidden name="club_event_id" value="<?= $event->id ?>">
                                    <button type="submit" name="submit" value="budget-redirect" class="button contained">
                                        <?= $event->is_budgets_verified ? 'Edit' : 'Update' ?>
                                    </button>
                                </form>
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

<?php $this->view('includes/header/side-bars/club-dashboard', $menu_side_bar) ?>
<?php $this->view('includes/modals/event/register') ?>

<script src="<?= ROOT ?>/assets/js/events/event.js"></script>