<head>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/side-bar.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/dashboard.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/club-dashboard.css">
</head>

<?php $this->view('includes/header') ?>

<div id="club-dashboard-add-meeting" class="container container-sections side-padding club-dashboard dashboard-container">
    <?php $this->view('includes/side-bars/club/dashboard/left', $left_bar) ?>

    <section class="center-section">
        <div class="title-bar">
            <div class="title-wrap">
                <span class="title">New Meeting</span>
            </div>
        </div>

        <div class="content-section">
            <form class="form" method="post">
                <div class="form-section">
                    <p class="form-section-title">Details</p>
                    <div class="form-section-content">
                        <div class="multi-wrap">
                            <div class="input-wrap">
                                <label for="name">Meeting Name</label>
                                <input value="<?= setValue('name') ?>" id="name" type="text" name="name" placeholder="Meeting Name" required>
                                <?php if (!empty($errors['name'])) : ?>
                                    <small>
                                        <?= $errors['name'] ?>
                                    </small>
                                <?php endif; ?>
                            </div>
                            <div class="input-wrap">
                                <label for="date">Date</label>
                                <input value="<?= setValue('date') ?>" id="date" type="date" name="date" placeholder="Meeting Date" required>
                                <?php if (!empty($errors['date'])) : ?>
                                    <small>
                                        <?= $errors['date'] ?>
                                    </small>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="multi-wrap">
                            <div class="input-wrap">
                                <label for="start_time">Start Time</label>
                                <input value="<?= setValue('start_time') ?>" id="start_time" type="time" name="start_time" placeholder="Start Time" required>
                                <?php if (!empty($errors['start_time'])) : ?>
                                    <small>
                                        <?= $errors['start_time'] ?>
                                    </small>
                                <?php endif; ?>
                            </div>
                            
                        </div>
                        <div class="multi-wrap">
                            <div class="input-wrap">
                                <label for="type_select">Choose Type</label>
                                <select value="type-select" name="type_select" id="type_select">
                                    <option value="" selected disabled hidden>Choose Type</option>
                                    <option value="1">COMMITTEE</option>
                                    <option value="2">CLOSED</option>
                                </select>
                                <?php if (!empty($errors['type_select'])) : ?>
                                    <small>
                                        <?= $errors['type_select'] ?>
                                    </small>
                                <?php endif; ?>
                            </div>
                            <div class="input-wrap"></div>
                        </div>

                        <div id="selected_members" class="selected-members"></div>

                        <div class="input-wrap">
                            <label for="description">Description</label>
                            <textarea value="<?= setValue('description') ?>" id="description" name="description" placeholder="Description" required></textarea>
                            <?php if (!empty($errors['description'])) : ?>
                                <small>
                                    <?= $errors['description'] ?>
                                </small>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="buttons-wrap">
                    <button type="submit" class="button contained" value= "create-meeting">Schedule</button>
                </div>
            </form>
        </div>
    </section>

</div>

<?php $this->view('includes/header/side-bars/club-dashboard', $menu_side_bar) ?>

<script src="<?= ROOT ?>/assets/js/club/dashboard/edit-meeting.js"></script>
<script src="<?= ROOT ?>/assets/js/form.js"></script>