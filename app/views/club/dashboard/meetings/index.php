<head>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/side-bar.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/dashboard.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/club-dashboard.css">
</head>

<?php $this->view('includes/header') ?>

<div id="club-dashboard-requests" class="container container-sections side-padding club-dashboard dashboard-container">
    <?php $this->view('includes/side-bars/club/dashboard/left', $left_bar) ?>

    <section class="center-section">
        <div class="title-bar">
            <div class="title-wrap">
                <span class="title">Meetings</span>
                <a href="<?= ROOT ?>/club/dashboard/meetings/add">
                    <button class="button" data-variant="outlined" data-type="icon" data-size="small">
                        <span>New Meeting</span>
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
                        <th>Meeting Name</th>
                        <th>Date</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>No. Attendants</th>
                        <th>No. Participants</th>
                        <th>Actions</th>
                    </tr>
                    <tr class="table-data">
                        <td>Freshers' Day</td>
                        <td>11/04/23</td>
                        <td>10.00 AM</td>
                        <td>12.00 AM</td>
                        <td>5</td>
                        <td>7</td>
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

<?php $this->view('includes/header/side-bars/club-dashboard', $menu_side_bar) ?>
<?php $this->view('includes/header/bottom') ?>