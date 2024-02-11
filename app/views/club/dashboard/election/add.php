<head>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/side-bar.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/dashboard.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/club-dashboard.css">
</head>

<?php $this->view('includes/header') ?>

<div id="club-dashboard-add-election" class="container container-sections side-padding club-dashboard dashboard-container">
    <?php $this->view('includes/side-bars/club/dashboard/left', $left_bar) ?>

    <section class="center-section">
        <div class="title-bar">
            <div class="title-wrap">
                <span class="title">New Election</span>
            </div>
        </div>

        <div class="content-section">
            <form class="form" method="post">
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
                                <option value="1">Freshers</option>
                            </select>
                            <?php if (!empty($errors['candidate'])) : ?>
                                <small>
                                    <?= $errors['candidate'] ?>
                                </small>
                            <?php endif; ?>
                        </div>

                        <div id="candidate-users" class="selected-users"></div>
                    </div>
                </div>
                <div class="form-section">
                    <p class="form-section-title">Voters</p>
                    <div class="form-section-content">
                        <div class="input-wrap">
                            <label for="voter">Choose Voter</label>
                            <select onchange="onAddUser(event, 'voter')" name="voter" id="voter" value="">
                                <option value="" selected disabled hidden>Choose Voter</option>
                                <option value="1">Freshers</option>
                            </select>
                            <?php if (!empty($errors['voter'])) : ?>
                                <small>
                                    <?= $errors['voter'] ?>
                                </small>
                            <?php endif; ?>
                        </div>

                        <div id="voter-users" class="selected-users"></div>
                    </div>
                </div>

                <div class="buttons-wrap">
                    <button type="submit" class="button contained">Create Election</button>
                </div>
            </form>
        </div>
    </section>

    <div class="checkbox-wrap user-template">
        <label class="checkbox-label">
            {{user_name}}
            <input hidden type="checkbox" checked name="{{type}}[id]" value="{{user_id}}">
            <input hidden type="checkbox" checked name="{{type}}[user_id]" value="{{user_user_id}}">
            <input hidden type="checkbox" checked name="{{type}}[name]" value="{{user_name}}">
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