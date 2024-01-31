<head>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/cards.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/side-bar.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/dashboard.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/club-dashboard.css">
</head>

<?php $this->view('includes/header') ?>

<!-- alerts -->
<?php $this->view('includes/alerts') ?>

<div id="club-dashboard-posts" class="container container-sections side-padding club-dashboard dashboard-container">
    <?php $this->view('includes/side-bars/club/dashboard/left', ["menu" => $menu]) ?>

    <section class="center-section">
        <div class="title-bar">
            <div class="title-wrap">
                <span class="title">Posts</span>
                <a href="<?= ROOT ?>/club/dashboard/posts/add">
                    <button class="button" data-variant="outlined" data-type="icon" data-size="small">
                        <span>New Post</span>
                        <span class="material-icons-outlined">
                            add
                        </span>
                    </button>
                </a>
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
                        <th>Post Title</th>
                        <th>Date & Time</th>
                        <th>Description</th>
                        <th>Published By</th>
                        <th>View</th>
                        <th>Actions</th>
                    </tr>
                    <?php if (count($posts_data) == 0) { ?>
                        <tr>
                            <td colspan="6">No Records.</td>
                        </tr>
                    <?php } ?>
                    <?php foreach ($posts_data as $x => $post_data) {
                    ?>
                        <tr class="table-data">
                            <td><?= displayValue($post_data->post_name) ?></td>
                            <td><?= displayValue($post_data->created_datetime, 'datetime') ?></td>
                            <td>
                                <p class="description truncate-text lines-2">
                                    <?= displayValue($post_data->description) ?>
                                </p>
                            </td>
                            <td><?= displayValue($post_data->first_name) ?> <?= displayValue($post_data->last_name) ?></td>
                            <td align="center">
                                <button onclick='onViewPost(<?= toJson($post_data, ["id", "post_name", "club_name", "club_image", "image", "description", "club_id", "created_datetime"]) ?>)' class="icon-button">
                                    <span class="material-icons-outlined">
                                        visibility
                                    </span>
                                </button>
                            </td>
                            <td align="center">
                                <div class="buttons">
                                    <form method="post">
                                        <input type="text" hidden name="club_post_id" value="<?= $post_data->id ?>">
                                        <button name="submit" value="post-redirect" class="icon-button">
                                            <span class="material-icons-outlined">
                                                edit
                                            </span>
                                        </button>
                                    </form>
                                    <button class="icon-button cl-red">
                                        <span onclick='onDataPopup("delete-club-post", <?= toJson($post_data, ["id"]) ?>)' class="material-icons-outlined">
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

<?php $this->view('includes/header/bottom') ?>

<?php $this->view('includes/modals/club/post') ?>
<?php $this->view('includes/modals/club/post/delete') ?>

<!-- club post view -->
<script src="<?= ROOT ?>/assets/js/club/dashboard/view-post.js"></script>

<script src="<?= ROOT ?>/assets/js/form.js"></script>