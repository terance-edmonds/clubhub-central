<head>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/side-bar.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/dashboard.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/club-dashboard.css">
</head>

<?php $this->view('includes/header') ?>

<div id="club-dashboard-logs" class="container container-sections side-padding club-dashboard dashboard-container">
    <?php $this->view('includes/side-bars/club/dashboard/left', $left_bar) ?>

    <section class="center-section">
        <div class="title-bar">
            <div class="title-wrap">
                <span class="title">Logs</span>
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

        <?php if ($tab == 'posts') { ?>
            <div class="content-section">
                <div class="action-buttons">
                    <a class="action-link" data-active="<?php if ($tab == 'posts')
                                                            echo 'true'; ?>" href="<?= ROOT ?>/club/dashboard/logs?tab=posts"><button class="button">Posts</button></a>
                    <a class="action-link" data-active="<?php if ($tab == 'budgets')
                                                            echo 'true'; ?>" href="<?= ROOT ?>/club/dashboard/logs?tab=budgets"><button class="button">Budgets</button></a>
                </div>
                <div class="table-wrap">
                    <table>
                        <tr class="table-header">
                            <th>User name</th>
                            <th>Email</th>
                            <th>Post ID</th>
                            <th>Action</th>
                            <th>View</th>
                            <th>Date & Time</th>
                        </tr>
                        <tr class="table-data">
                            <td>John</td>
                            <td>john@mailinator.com</td>
                            <td align="center">1</td>
                            <td>Updated a post</td>
                            <td align="center">
                                <button class="icon-button">
                                    <span class="material-icons-outlined">
                                        visibility
                                    </span>
                                </button>
                            </td>
                            <td>
                                11/04/23 - 10.00 AM
                            </td>
                        </tr>

                    </table>
                </div>
            </div>
        <?php } else if ($tab == 'budgets') { ?>
            <div class="content-section">
                <div class="action-buttons">
                    <a class="action-link" data-active="<?php if ($tab == 'posts')
                                                            echo 'true'; ?>" href="<?= ROOT ?>/club/dashboard/logs?tab=posts"><button class="button">Posts</button></a>
                    <a class="action-link" data-active="<?php if ($tab == 'budgets')
                                                            echo 'true'; ?>" href="<?= ROOT ?>/club/dashboard/logs?tab=budgets"><button class="button">Budgets</button></a>
                </div>
                <div class="table-wrap">
                    <table>
                        <tr class="table-header">
                            <th>User name</th>
                            <th>Email</th>
                            <th>Budget ID</th>
                            <th>Action</th>
                            <th>Date & Time</th>
                        </tr>
                        <tr class="table-data">
                            <td>John</td>
                            <td>john@mailinator.com</td>
                            <td align="center">1</td>
                            <td>Updated a budget</td>
                            <td>
                                11/04/23 - 10.00 AM
                            </td>
                        </tr>

                    </table>
                </div>
            </div>
        <?php } ?>
    </section>
</div>

<?php $this->view('includes/header/bottom') ?>