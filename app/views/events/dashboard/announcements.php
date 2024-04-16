<head>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/side-bar.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/dashboard.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/event-dashboard.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/data-loader.css">
</head>

<?php $this->view('includes/header') ?>

<!-- alerts -->
<?php $this->view('includes/alerts') ?>

<div id="event-dashboard-announcements" class="container container-sections side-padding event-dashboard dashboard-container">
    <?php $this->view('includes/side-bars/events/dashboard/left', $left_bar) ?>

    <section class="center-section">
        <div class="title-bar">
            <div class="title-wrap">
                <span class="title">Announcements</span>
            </div>
        </div>

        <div class="content-section">
            <form class="form" method="post">
                <div class="form-section">
                    <p class="form-section-title">General Details</p>
                    <div class="form-section-content">
                        <div class="input-wrap">
                            <div class="multi-wrap flex-between">
                                <label for="to">To</label>

                                <button type="button" onclick="onSelectUsersPopup(true)" class="button contained w-content" class="button" data-variant="outlined" data-type="icon" data-size="small">
                                    <span>Select Users</span>
                                    <span class="material-icons-outlined">
                                        add
                                    </span>
                                </button>
                            </div>

                            <div id="selected_members" class="selected-members"></div>
                        </div>
                        <div class="input-wrap">
                            <label for="subject">Subject</label>
                            <input value="<?= setValue('subject') ?>" id="subject" type="text" name="subject" placeholder="Subject" required>
                            <?php if (!empty($errors['subject'])) : ?>
                                <small>
                                    <?= $errors['subject'] ?>
                                </small>
                            <?php endif; ?>
                        </div>
                        <div class="input-wrap">
                            <label for="description">Description</label>
                            <textarea id="description" type="text" name="description" placeholder="Description" required><?= setValue('description') ?></textarea>
                            <?php if (!empty($errors['description'])) : ?>
                                <small>
                                    <?= $errors['description'] ?>
                                </small>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="buttons-wrap">
                    <button type="submit" name="submit" value="send-email" class="button contained">Send
                        Email</button>
                </div>
            </form>
        </div>
    </section>

    <div class="checkbox-wrap selected-member-template">
        <label class="checkbox-label">
            {{selected_member_email}}
            <input hidden type="checkbox" checked name="selected_member[{{selected_member_email}}]" value="{{selected_member_id}}">
        </label>
        <span onclick="onRemoveMember(event)" class="material-icons-outlined">
            clear
        </span>
    </div>
</div>


<?php $this->view('includes/header/side-bars/event-dashboard', $menu_side_bar) ?>

<?php $this->view('includes/modals/event/users', $select_users) ?>

<script src="<?= ROOT ?>/assets/js/events/announcements.js"></script>
<script src="<?= ROOT ?>/assets/js/form.js"></script>