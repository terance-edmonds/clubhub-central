
<head>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/side-bar.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/dashboard.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/club-dashboard.css">
</head>

<?php $this->view('includes/header') ?>

<div id="club-dashboard-event" class="container container-sections side-padding club-dashboard dashboard-container">
    <?php $this->view('includes/side-bars/club/dashboard/left', ["menu" => $menu])  ?>

    <section class="center-section">
        <div class="title-bar">
            <div class="title-wrap">
                <span class="title">Elections</span>
            </div>

            <div class="input-wrap search-input">
                <div class="input">
                    <span class="icon material-icons-outlined">
                        search
                    </span>
                    <input type="text" placeholder="Search Candidate">
                </div>
            </div>
        </div>

        <div class="content-section">
            <div class="table-wrap">
                <table>
                    <tr class="table-header">
                        <th>Name</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    <tr class="table-data">
                        <td>Election 1</td>
                        <td>
                            <button class="button status-button" data-status="APPROVED">
                                Published
                            </button>
                        </td>
                        <td align="center">
                            <div class="action-buttons">
                                <a class="action-link" data-active="<?php if ($tab == 'rejected') echo 'true'; ?>" href="<?= ROOT ?>/club/dashboard/members?tab=rejected"><button class="button">Vote</button></a>
                            </div>
                        </td>
                    </tr>
                    <tr class="table-data">
                        <td>Election 2</td>
                        <td>
                            <button class="button status-button" data-status="REJECTED">
                                Closed
                            </button>
                        </td>
                        <td align="center">
                            <div class="action-buttons">
                                <a class="action-link" data-active="<?php if ($tab == 'rejected') echo 'true'; ?>" href="<?= ROOT ?>/club/dashboard/members?tab=rejected"><button class="button">Vote</button></a>
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