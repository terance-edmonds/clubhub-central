<head>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/side-bar.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/dashboard.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/admin-dashboard.css">
</head>

<?php $this->view('includes/header') ?>

<div id="admin-dashboard-requests" class="container container-sections side-padding admin-dashboard dashboard-container">
    <?php $this->view('includes/side-bars/admin/left', ["menu" => $menu])  ?>

    <section class="center-section">
        <div class="title-bar">
            <div class="title-wrap">
                <span class="title">Requests</span>
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
                        <th>Subject</th>
                        <th>Date & Time</th>
                        <th>Venue</th>
                        <th>View</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    <tr class="table-data">
                        <td>Freshers' Day</td>
                        <td>11/04/23 - 10.00 AM</td>
                        <td>UCSC Ground</td>
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
                                <button class="icon-button cl-green">
                                    <span class="material-icons-outlined">
                                        check
                                    </span>
                                </button>
                                <button class="icon-button cl-red">
                                    <span class="material-icons-outlined">
                                        close
                                    </span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr class="table-data">
                        <td>Freshers' Day</td>
                        <td>11/04/23 - 10.00 AM</td>
                        <td>UCSC Ground</td>
                        <td align="center">
                            <button class="icon-button">
                                <span class="material-icons-outlined">
                                    visibility
                                </span>
                            </button>
                        </td>
                        <td>
                            <button class="button status-button" data-status="APPROVED">
                                Approved
                            </button>
                        </td>
                        <td align="center">
                            <div class="buttons">
                                <button class="icon-button cl-green">
                                    <span class="material-icons-outlined">
                                        check
                                    </span>
                                </button>
                                <button class="icon-button cl-red">
                                    <span class="material-icons-outlined">
                                        close
                                    </span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr class="table-data">
                        <td>Freshers' Day</td>
                        <td>11/04/23 - 10.00 AM</td>
                        <td>UCSC Ground</td>
                        <td align="center">
                            <button class="icon-button">
                                <span class="material-icons-outlined">
                                    visibility
                                </span>
                            </button>
                        </td>
                        <td>
                            <button class="button status-button" data-status="REJECTED">
                                Rejected
                            </button>
                        </td>
                        <td align="center">
                            <div class="buttons">
                                <button class="icon-button cl-green">
                                    <span class="material-icons-outlined">
                                        check
                                    </span>
                                </button>
                                <button class="icon-button cl-red">
                                    <span class="material-icons-outlined">
                                        close
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

<?php $this->view('includes/modals/event/register')  ?>
<script src="<?= ROOT ?>/assets/js/events/event.js"></script>