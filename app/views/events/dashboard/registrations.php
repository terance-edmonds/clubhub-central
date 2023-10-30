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

        <label class="checkbox-label">
            <span>Open Registrations</span>

            <label class="switch">
                <input type="checkbox">
                <span class="slider"></span>
            </label>
        </label>

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
                    <tr class="table-data">
                        <td>Participants Name</td>
                        <td>0771234567</td>
                        <td>dev@mailinator.com</td>
                        <td>
                            <button class="button status-button" data-attended="false">
                                Pending
                            </button>
                        </td>
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
                    <tr class="table-data">
                        <td>Participants Name</td>
                        <td>0771234567</td>
                        <td>dev@mailinator.com</td>
                        <td>
                            <button class="button status-button" data-attended="true">
                                Attended
                            </button>
                        </td>
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

<?php $this->view('includes/modals/event/register') ?>