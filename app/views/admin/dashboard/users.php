<head>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/side-bar.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/dashboard.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/admin-dashboard.css">
</head>

<?php $this->view('includes/header') ?>

<div id="admin-dashboard-users" class="container container-sections side-padding admin-dashboard dashboard-container">
    <?php $this->view('includes/side-bars/admin/left', ["menu" => $menu]) ?>

    <section class="center-section">
        <div class="title-bar">
            <div class="title-wrap">
                <span class="title">Users</span>
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
                        <th>First Name</th>
                        <th>Last Name</th>
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

                    <?php foreach ($users_data as $user_data) {
                        $user =  (object) $user_data[0];
                    ?>
                        <tr class="table-data">
                            <td><?= displayValue($user->first_name) ?></td>
                            <td><?= displayValue($user->last_name) ?></td>
                            <td><?= displayValue($user->email) ?></td>
                            <td align="center">
                                <button onclick="$(`[popup-name='user-<?= $user->id ?>-clubs']`).popup(true)" <?php if ($user->total_clubs == 0) { ?> disabled <?php } ?> class="icon-button">
                                    <span class="material-icons-outlined">
                                        visibility
                                    </span>
                                </button>
                            </td>
                            <td align="center">
                                <?php if ($user->is_verified) { ?>
                                    <span class="material-icons cl-green">
                                        check_circle_outline
                                    </span>
                                <?php } else { ?>
                                    <span class="material-icons-outlined cl-red">
                                        cancel
                                    </span>
                                <?php } ?>
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

                        <?php $this->view('includes/modals/admin/users/clubs', [
                            "id" => $user->id,
                            "clubs" => $user_data
                        ]) ?>
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

<?php $this->view('includes/header/bottom') ?>

<script src="<?= ROOT ?>/assets/js/users/user.js"></script>