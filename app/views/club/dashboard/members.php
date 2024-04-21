<head>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/side-bar.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/dashboard.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/club-dashboard.css">
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
            <div class="action-buttons">
                <a class="action-link" data-active="<?php if ($tab == 'accepted')
                                                        echo 'true'; ?>" href="<?= ROOT ?>/club/dashboard/members?tab=accepted"><button class="button">Accepted</button></a>
                <a class="action-link" data-active="<?php if ($tab == 'rejected')
                                                        echo 'true'; ?>" href="<?= ROOT ?>/club/dashboard/members?tab=rejected"><button class="button">Rejected</button></a>
                <a class="action-link" data-active="<?php if ($tab == 'requested')
                                                        echo 'true'; ?>" href="<?= ROOT ?>/club/dashboard/members?tab=requested"><button class="button">Requested</button></a>
            </div>
            <div class="table-wrap">
                <table>
                    <tr class="table-header">
                        <th>Reg No.</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Documents</th>
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
        </div>
    </section>
</div>

<?php $this->view('includes/header/side-bars/club-dashboard', $menu_side_bar) ?>

<?php $this->view('includes/modals/club/member/delete') ?>

<script src="<?= ROOT ?>/assets/js/form.js"></script>