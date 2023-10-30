<head>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/side-bar.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/dashboard.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/club-dashboard.css">
</head>

<?php $this->view('includes/header') ?>

<div id="club-dashboard-members" class="container container-sections side-padding club-dashboard dashboard-container">
    <?php $this->view('includes/side-bars/club/dashboard/left', ["menu" => $menu])  ?>

    <section class="center-section">
        <div class="title-bar">
            <div class="title-wrap">
                <span class="title">Members</span>
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
            <div class="action-buttons">
                <a class="action-link" data-active="<?php if ($type == 'ACCEPTED') echo 'true'; ?>" href="<?= ROOT ?>/club/dashboard/members?type=accepted"><button class="button">Accepted</button></a>
                <a class="action-link" data-active="<?php if ($type == 'REJECTED') echo 'true'; ?>" href="<?= ROOT ?>/club/dashboard/members?type=rejected"><button class="button">Rejected</button></a>
                <a class="action-link" data-active="<?php if ($type == 'REQUESTED') echo 'true'; ?>" href="<?= ROOT ?>/club/dashboard/members?type=requested"><button class="button">Requested</button></a>
            </div>
            <div class="table-wrap">
                <table>
                    <tr class="table-header">
                        <th>Index No.</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Reg No.</th>
                        <th>Documents</th>
                        <th>Actions</th>
                    </tr>
                    <tr class="table-data">
                        <td>22120001</td>
                        <td>John</td>
                        <td>john@email.com</td>
                        <td>0001</td>
                        <td align="center">
                            <button class="icon-button">
                                <span class="material-icons-outlined">
                                    visibility
                                </span>
                            </button>
                        </td>

                        <td align="center">
                            <button class="icon-button cl-red">
                                <span class="material-icons-outlined">
                                    delete
                                </span>
                            </button>
                        </td>
                    </tr>

                </table>
            </div>
        </div>
    </section>
</div>

<?php $this->view('includes/modals/event/register')  ?>
<script src="<?= ROOT ?>/assets/js/events/event.js"></script>