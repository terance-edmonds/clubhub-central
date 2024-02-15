<head>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/side-bar.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/dashboard.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/club-dashboard.css">
</head>

<?php $this->view('includes/header') ?>

<?php $this->view('includes/alerts') ?>

<div id="club-dashboard-edit-election" class="container container-sections side-padding club-dashboard dashboard-container">
    <?php $this->view('includes/side-bars/club/dashboard/left', $left_bar) ?>

    <section class="center-section">
        <div class="title-bar">
            <div class="title-wrap">
                <span class="title">Edit Election</span>
            </div>
        </div>

        <div class="content-section">
            <form class="form" method="post">
                <input type="text" hidden name="id" value="<?= setValue('id') ?>">
                <div class="form-section">
                    <p class="form-section-title">Details</p>
                    <div class="form-section-content">
                        <div class="input-wrap">
                            <label for="title">Title</label>
                            <input value="<?= setValue('title') ?>" id="title" name="title" placeholder="Title" required />
                            <?php if (!empty($errors['title'])) : ?>
                                <small>
                                    <?= $errors['title'] ?>
                                </small>
                            <?php endif; ?>
                        </div>

                        <div class="multi-wrap">
                            <div class="input-wrap">
                                <label for="start_datetime">Start Date & Time</label>
                                <input set-default="datetime" value="<?= setValue('start_datetime') ?>" id="start_datetime" type="datetime-local" name="start_datetime" placeholder="Start Date & Time" required>
                                <?php if (!empty($errors['start_datetime'])) : ?>
                                    <small>
                                        <?= $errors['start_datetime'] ?>
                                    </small>
                                <?php endif; ?>
                            </div>
                            <div class="input-wrap">
                                <label for="end_datetime">End Date & Time</label>
                                <input set-default="datetime" value="<?= setValue('end_datetime') ?>" id="end_datetime" type="datetime-local" name="end_datetime" placeholder="End Date & Time" required>
                                <?php if (!empty($errors['end_datetime'])) : ?>
                                    <small>
                                        <?= $errors['end_datetime'] ?>
                                    </small>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="input-wrap">
                            <label for="description">Description</label>
                            <textarea id="description" name="description" placeholder="Description" required><?= setValue('description') ?></textarea>
                            <?php if (!empty($errors['description'])) : ?>
                                <small>
                                    <?= $errors['description'] ?>
                                </small>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="form-section">
                    <p class="form-section-title">Candidates</p>
                    <div class="form-section-content">
                        <div class="checkbox-filters">
                            <label class="checkbox-label">
                                <input type="checkbox" name="event_attendance" value="event_attendance">
                                80% Event Attendance
                            </label>
                        </div>
                        <div class="input-wrap">
                            <label for="candidate">Choose Candidate</label>
                            <select onchange="onAddUser(event, 'candidate')" name="candidate" id="candidate" value="">
                                <option value="" selected disabled hidden>Choose Candidate</option>
                                <?php foreach ($candidate_members_data as $club_member) { ?>
                                    <option value="<?= $club_member->id ?>,<?= $club_member->user_id ?>">
                                        <?= $club_member->first_name ?>
                                        <?= $club_member->last_name ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <?php if (!empty($errors['candidate'])) : ?>
                                <small>
                                    <?= $errors['candidate'] ?>
                                </small>
                            <?php endif; ?>
                        </div>

                        <div id="candidate-users" class="selected-users">
                            <?php if (!empty($_POST['candidate'])) { ?>
                                <?php foreach ($_POST['candidate'] as $key => $group) { ?>
                                    <div class="checkbox-wrap user-template">
                                        <label class="checkbox-label">
                                            <?= $group['name'] ?>
                                            <input hidden type="checkbox" checked name="candidate[<?= $key ?>][id]" value="<?= $group['id'] ?>">
                                            <input hidden type="checkbox" checked name="candidate[<?= $key ?>][user_id]" value="<?= $group['user_id'] ?>">
                                            <input hidden type="checkbox" checked name="candidate[<?= $key ?>][name]" value="<?= $group['name'] ?>">
                                        </label>
                                        <span onclick="onRemoveUser(event)" class="material-icons-outlined">
                                            clear
                                        </span>
                                    </div>
                            <?php }
                            } ?>
                        </div>
                    </div>
                </div>
                <div class="form-section">
                    <p class="form-section-title">Voters</p>
                    <div class="form-section-content">
                        <div class="input-wrap">
                            <label for="voter">Choose Voter</label>
                            <select onchange="onAddUser(event, 'voter')" name="voter" id="voter" value="">
                                <option value="" selected disabled hidden>Choose Voter</option>
                                <?php foreach ($vote_members_data as $club_member) { ?>
                                    <option value="<?= $club_member->id ?>,<?= $club_member->user_id ?>">
                                        <?= $club_member->first_name ?>
                                        <?= $club_member->last_name ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <?php if (!empty($errors['voter'])) : ?>
                                <small>
                                    <?= $errors['voter'] ?>
                                </small>
                            <?php endif; ?>
                        </div>

                        <div id="voter-users" class="selected-users">
                            <?php if (!empty($_POST['voter'])) { ?>
                                <?php foreach ($_POST['voter'] as $key => $group) { ?>
                                    <div class="checkbox-wrap user-template">
                                        <label class="checkbox-label">
                                            <?= $group['name'] ?>
                                            <input hidden type="checkbox" checked name="voter[<?= $key ?>][id]" value="<?= $group['id'] ?>">
                                            <input hidden type="checkbox" checked name="voter[<?= $key ?>][user_id]" value="<?= $group['user_id'] ?>">
                                            <input hidden type="checkbox" checked name="voter[<?= $key ?>][name]" value="<?= $group['name'] ?>">
                                        </label>
                                        <span onclick="onRemoveUser(event)" class="material-icons-outlined">
                                            clear
                                        </span>
                                    </div>
                            <?php }
                            } ?>
                        </div>
                    </div>
                </div>

                <div class="buttons-wrap">
                    <button type="submit" name="submit" value="edit-election" class="button contained">Update Election</button>
                </div>
            </form>
        </div>
    </section>

    <div class="checkbox-wrap user-template">
        <label class="checkbox-label">
            {{user_name}}
            <input hidden type="checkbox" checked name="{{type}}[{{group_id}}][id]" value="{{user_id}}">
            <input hidden type="checkbox" checked name="{{type}}[{{group_id}}][user_id]" value="{{user_user_id}}">
            <input hidden type="checkbox" checked name="{{type}}[{{group_id}}][name]" value="{{user_name}}">
        </label>
        <span onclick="onRemoveUser(event)" class="material-icons-outlined">
            clear
        </span>
    </div>
</div>

<?php $this->view('includes/modals/event/register') ?>
<?php $this->view('includes/header/side-bars/club-dashboard', $menu_side_bar) ?>

<script src="<?= ROOT ?>/assets/js/club/dashboard/election.js"></script>
<script src="<?= ROOT ?>/assets/js/form.js"></script>