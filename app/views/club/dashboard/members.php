<head>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/side-bar.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/dashboard.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/club-dashboard.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/data-loader.css">
</head>

<?php $this->view('includes/header') ?>

<?php $this->view('includes/alerts') ?>

<div id="club-dashboard-members" class="container container-sections side-padding club-dashboard dashboard-container">
    <?php $this->view('includes/side-bars/club/dashboard/left', $left_bar) ?>

    <section class="center-section">
        <div class="title-bar">
            <div class="title-wrap">
                <span class="title">Members</span>
            </div>

            <?php if ($tab != 'administrators') { ?>
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
            <?php } ?>
        </div>

        <div class="content-section">
            <div class="action-buttons">
                <a class="action-link" data-active="<?php if ($tab == 'accepted')
                                                        echo 'true'; ?>" href="<?= ROOT ?>/club/dashboard/members?tab=accepted"><button class="button">Accepted</button></a>
                <a class="action-link" data-active="<?php if ($tab == 'rejected')
                                                        echo 'true'; ?>" href="<?= ROOT ?>/club/dashboard/members?tab=rejected"><button class="button">Rejected</button></a>
                <a class="action-link" data-active="<?php if ($tab == 'requested')
                                                        echo 'true'; ?>" href="<?= ROOT ?>/club/dashboard/members?tab=requested"><button class="button">Requested</button></a>
                <?php if ($role == 'CLUB_IN_CHARGE') { ?>
                    <a class="action-link" data-active="<?php if ($tab == 'administrators')
                                                            echo 'true'; ?>" href="<?= ROOT ?>/club/dashboard/members?tab=administrators"><button class="button">Administrators</button></a>
                <?php } ?>
            </div>

            <?php if ($role == 'CLUB_IN_CHARGE' && $tab == 'administrators') { ?>
                <div class="club-administrators">
                    <div class="club-administrator">
                        <h3 class="role">President</h3>

                        <div class="details">
                            <div class="section">
                                <div class="user-image">
                                    <img src="<?php echo (!empty($president->image)) ? $president->image : ROOT . '/assets/images/other/empty-profile.jpg' ?>" alt="User" class="image">
                                </div>

                                <p class="name">
                                    <span><b>Name: </b></span><span><?= empty($president->name) ? 'Not Assigned' : displayValue($president->name) ?></span>
                                </p>
                                <p class="name">
                                    <span><b>Email: </b></span><span><?= empty($president->email) ? 'Not Assigned' : displayValue($president->email) ?></span>
                                </p>
                            </div>

                            <div class="section">
                                <button onclick=" onSelectUsersPopup(true, 'PRESIDENT')" class="button w-content" data-variant="outlined">
                                    Change
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="club-administrator">
                        <h3 class="role">Secretary</h3>

                        <div class="details">
                            <div class="section">
                                <div class="user-image">
                                    <img src="<?php echo (!empty($secretary->image)) ? $secretary->image : ROOT . '/assets/images/other/empty-profile.jpg' ?>" alt="User" class="image">
                                </div>

                                <p class="name">
                                    <span><b>Name: </b></span><span><?= empty($secretary->name) ? 'Not Assigned' : displayValue($secretary->name) ?></span>
                                </p>
                                <p class="name">
                                    <span><b>Email: </b></span><span><?= empty($secretary->email) ? 'Not Assigned' : displayValue($secretary->email) ?></span>
                                </p>
                            </div>

                            <div class="section">
                                <button onclick=" onSelectUsersPopup(true, 'SECRETARY')" class="button w-content" data-variant="outlined">
                                    Change
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="club-administrator">
                        <h3 class="role">Treasurer</h3>

                        <div class="details">
                            <div class="section">
                                <div class="user-image">
                                    <img src="<?php echo (!empty($treasurer->image)) ? $treasurer->image : ROOT . '/assets/images/other/empty-profile.jpg' ?>" alt="User" class="image">
                                </div>

                                <p class="name">
                                    <span><b>Name: </b></span><span><?= empty($treasurer->name) ? 'Not Assigned' : displayValue($treasurer->name) ?></span>
                                </p>
                                <p class="name">
                                    <span><b>Email: </b></span><span><?= empty($treasurer->email) ? 'Not Assigned' : displayValue($treasurer->email) ?></span>
                                </p>
                            </div>

                            <div class="section">
                                <button onclick=" onSelectUsersPopup(true, 'TREASURER')" class="button w-content" data-variant="outlined">
                                    Change
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } else { ?>
                <div class="table-wrap">
                    <table>
                        <tr class="table-header">
                            <th>Reg No.</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Documents</th>
                            <th>State</th>
                            <th>Actions</th>
                        </tr>
                        <?php foreach ($table_data as $x => $val) {
                        ?>
                            <tr class="table-data">
                                <td>
                                    <?= displayValue($val->id) ?>
                                </td>
                                <td>
                                    <?= displayValue($val->first_name) ?> <?= displayValue($val->last_name) ?>
                                </td>
                                <td>
                                    <?= displayValue($val->email) ?>
                                </td>
                                <td align="center">
                                    <a target="_blank" href="<?php echo !empty($val->document_link) ? $val->document_link : 'javascript:void(0);' ?>">
                                        <button <?php if (empty($val->document_link)) { ?> disabled <?php } ?> class="icon-button">
                                            <span class="material-icons-outlined">
                                                visibility
                                            </span>
                                        </button>
                                    </a>
                                </td>
                                <td>
                                    <button <?php if ($club_role == 'CLUB_IN_CHARGE' || $club_role == 'PRESIDENT') { ?> onclick='onDataPopup("club-member-state", <?= toJson($val, ["id", "state"]) ?>)' <?php } ?> class="button status-button <?= ($club_role == 'CLUB_IN_CHARGE' || $club_role == 'PRESIDENT') ? 'pointer-cursor' : '' ?>" data-status="<?= $val->state ?>">
                                        <?= displayValue($val->state, 'start-case') ?>
                                    </button>
                                </td>
                                <td align="center">
                                    <button onclick='onDataPopup("delete-club-member", <?= toJson($val, ["id"]) ?>)' title="Delete Member" class="icon-button cl-red">
                                        <span class="material-icons-outlined">
                                            delete
                                        </span>
                                    </button>
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
            <?php } ?>
        </div>
    </section>
</div>

<?php $this->view('includes/header/side-bars/club-dashboard', $menu_side_bar) ?>

<?php $this->view('includes/modals/club/member/delete') ?>

<?php if ($club_role == 'CLUB_IN_CHARGE' && $tab == 'administrators') {
    $this->view('includes/modals/club/member/users', $select_users);
} ?>

<?php if ($club_role == 'CLUB_IN_CHARGE' || $club_role == 'PRESIDENT') {
    $this->view('includes/modals/club/member/status');
?>
    <script>
        <?php if (!empty($popups["club-member-state"])) { ?>
            $(`[popup-name='club-member-state']`).popup(true)
        <?php } ?>
    </script>
<?php } ?>

<script src="<?= ROOT ?>/assets/js/club/dashboard/members.js"></script>
<script src="<?= ROOT ?>/assets/js/form.js"></script>