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
                <span class="title">Users</span>
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
                        <th>Name</th>
                        <th>Email</th>
                        <th>Assigned Clubs</th>
                        <th>Verified</th>
                        <th>Actions</th>
                    </tr>

                    <?php if (count($users_data) == 0) { ?>
                        <tr>
                            <td colspan="5">No Records.</td>
                        </tr>
                    <?php } ?>

                    <?php foreach ($users_data as $user) { ?>
                        <tr class="table-data">

                        
                            <td>
                                <?= displayValue($user->name) ?>
                            </td>


                            <td>
                                <?= displayValue($user->email) ?>
                            </td>


                            <td align="center">
                                <button class="icon-button">
                                    <span class="material-icons-outlined">
                                        visibility
                                    </span>
                                </button>
                            </td>


                            <td align="center">
                                <span class="material-icons cl-green">
                                    check_circle_outline
                                </span>
                            </td>

                            <td align="center">
                                <div class="buttons">
                                    <a href="<?= ROOT ?>/users/dashboard">
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

<?php $this->view('includes/modals/user/register') ?>
<script src="<?= ROOT ?>/assets/js/users/user.js"></script>

<?php $this->view('includes/header/bottom') ?>




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
                <span class="title">Users</span>
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
                        <th>Name</th>
                        <th>Email</th>
                        <th>Assigned Clubs</th>
                        <th>Verified</th>
                        <th>Actions</th>
                    </tr>
                    <tr class="table-data">
                        <td>John</td>
                        <td>john@mailinator.com</td>
                        <td align="center">
                            <button class="icon-button">
                                <span class="material-icons-outlined">
                                    visibility
                                </span>
                            </button>
                        </td>

                        <td align="center">
                            <span class="material-icons cl-green">
                                check_circle_outline
                            </span>
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
                    <tr class="table-data">
                        <td>John</td>
                        <td>john@mailinator.com</td>
                        <td align="center">
                            <button class="icon-button">
                                <span class="material-icons-outlined">
                                    visibility
                                </span>
                            </button>
                        </td>
                        <td align="center">
                            <span class="material-icons cl-red">
                                highlight_off
                            </span>
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
<script src="<?= ROOT ?>/assets/js/events/event.js"></script>

<?php $this->view('includes/header/bottom') ?>