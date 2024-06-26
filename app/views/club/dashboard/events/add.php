<head>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/side-bar.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/dashboard.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/event-dashboard.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/data-loader.css">
</head>

<?php $this->view('includes/header') ?>

<?php $this->view('includes/alerts') ?>

<div id="event-dashboard-event-add" class="container container-sections side-padding event-dashboard dashboard-container">
    <?php $this->view('includes/side-bars/club/dashboard/left', $left_bar) ?>

    <section class="center-section no-padding">
        <div class="title-bar set-padding">
            <div class="title-wrap">
                <span class="title">Create Event</span>
            </div>
        </div>

        <div class="content-section">
            <form class="form" method="post">
                <div class="form-section">
                    <p class="form-section-title">General Details</p>
                    <div class="form-section-content">
                        <div class="multi-wrap">
                            <div class="input-wrap">
                                <label for="name">Event Name</label>
                                <input value="<?= setValue('name') ?>" id="name" type="text" name="name" placeholder="Event Name" required>
                                <?php if (!empty($errors['name'])) : ?>
                                    <small>
                                        <?= $errors['name'] ?>
                                    </small>
                                <?php endif; ?>
                            </div>
                            <div class="input-wrap">
                                <label for="venue">Venue</label>
                                <input value="<?= setValue('venue') ?>" id="venue" type="text" name="venue" placeholder="Venue" required>
                                <?php if (!empty($errors['venue'])) : ?>
                                    <small>
                                        <?= $errors['venue'] ?>
                                    </small>
                                <?php endif; ?>
                            </div>
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

                    <div class="input-wrap">
                        <label for="created_datetime">Create On</label>
                        <input set-default="datetime" readonly value="<?= setValue('created_datetime') ?>" id="created_datetime" type="datetime-local" name="created_datetime" placeholder="Created Date & Time" required>
                        <?php if (!empty($errors['created_datetime'])) : ?>
                            <small>
                                <?= $errors['created_datetime'] ?>
                            </small>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-section groups">
                    <div id="event-groups-section" class="form-section-title-wrap">
                        <p class="form-section-title">Group Details</p>
                        <div onclick="onAddNewGroup()" class="button" data-variant="outlined" data-type="icon" data-size="small">
                            <span>Add New</span>
                            <span class="material-icons-outlined">
                                add
                            </span>
                        </div>
                    </div>

                    <?php if (!empty($_POST['groups'])) { ?>
                        <?php foreach ($_POST['groups'] as $key => $group) { ?>
                            <div id="<?= $key ?>" class="form-section-content group-form-section">
                                <div class="multi-wrap">
                                    <div class="input-wrap">
                                        <label for="<?= $key ?>-name">Group Name</label>
                                        <input value="<?= setValue("groups[$key][name]") ?>" id="<?= $key ?>-name" type="text" name="groups[<?= $key ?>][name]" placeholder="Group Name" required>
                                        <?php if (!empty($errors["groups[$key][name]"])) : ?>
                                            <small>
                                                <?= $errors["groups[$key][name]"] ?>
                                            </small>
                                        <?php endif; ?>
                                    </div>
                                    <div class="input-wrap">
                                        <label>Group Members</label>

                                        <button type="button" onclick="onSelectUsersPopup(true, '<?= $key ?>')" class="button contained w-content" class="button" data-variant="outlined" data-type="icon" data-size="small">
                                            <span>Select Users</span>
                                            <span class="material-icons-outlined">
                                                add
                                            </span>
                                        </button>

                                        <?php if (!empty($errors["groups[$key][group_member]"])) : ?>
                                            <small>
                                                <?= $errors["groups[$key][group_member]"] ?>
                                            </small>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div id="<?= $key ?>-group_members" class="group-members">
                                    <?php foreach ($group['members'] as $member) { ?>
                                        <div class="checkbox-wrap">
                                            <label data-<?= $key ?>="<?= $member['id'] ?>" class="checkbox-label">
                                                <?= $member['name'] ?>
                                                <input hidden type="checkbox" checked name="groups[<?= $key ?>][members][<?= $member['id'] ?>][id]" value="<?= $member['id'] ?>">
                                                <input hidden type="checkbox" checked name="groups[<?= $key ?>][members][<?= $member['id'] ?>][user_id]" value="<?= $member['user_id'] ?>">
                                                <input hidden type="checkbox" checked name="groups[<?= $key ?>][members][<?= $member['id'] ?>][name]" value="<?= $member['name'] ?>">
                                            </label>
                                            <span onclick="onRemoveGroupMember(event)" class="material-icons-outlined">
                                                clear
                                            </span>
                                        </div>
                                    <?php } ?>
                                </div>

                                <div class="sub-section">
                                    <p class="sub-section-title">Allow Access To</p>
                                    <div class="checkboxes-wrap">
                                        <label class="checkbox-label">
                                            <input <?php if (!empty($group['permissions']['budget_permission'])) { ?> checked <?php } ?> type="checkbox" name="groups[<?= $key ?>][permissions][budget_permission]" value="1">
                                            Budgets
                                        </label>
                                        <label class="checkbox-label">
                                            <input <?php if (!empty($group['permissions']['details_permission'])) { ?> checked <?php } ?> type="checkbox" name="groups[<?= $key ?>][permissions][details_permission]" value="1">
                                            Event Details
                                        </label>
                                        <label class="checkbox-label">
                                            <input <?php if (!empty($group['permissions']['registration_permission'])) { ?> checked <?php } ?> type="checkbox" name="groups[<?= $key ?>][permissions][registration_permission]" value="1">
                                            Registration
                                        </label>
                                        <label class="checkbox-label">
                                            <input <?php if (!empty($group['permissions']['sponsor_permission'])) { ?> checked <?php } ?> type="checkbox" name="groups[<?= $key ?>][permissions][sponsor_permission]" value="1">
                                            Sponsors
                                        </label>
                                    </div>
                                </div>

                                <div class="form-section-buttons-wrap">
                                    <button type="button" onclick="onRemoveGroup('<?= $key ?>')" class="icon-button cl-red remove-group-btn">
                                        <span class="material-icons-outlined">
                                            delete
                                        </span>
                                    </button>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>

                <div class="buttons-wrap">
                    <button type="submit" name="submit" value="create_event" class="button contained">Create Event</button>
                </div>
            </form>
        </div>
    </section>


    <div id="{{group_name}}" class="form-section-content group-template group-form-section">
        <div class="multi-wrap">
            <div class="input-wrap">
                <label for="{{group_name}}-name">Group Name</label>
                <input value="<?= setValue("groups[{{group_name}}][name]") ?>" id="{{group_name}}-name" type="text" name="groups[{{group_name}}][name]" placeholder="Group Name" required>
                <?php if (!empty($errors["groups[{{group_name}}][name]"])) : ?>
                    <small>
                        <?= $errors["groups[{{group_name}}][name]"] ?>
                    </small>
                <?php endif; ?>
            </div>
            <div class="input-wrap">
                <label>Group Members</label>

                <button type="button" onclick="onSelectUsersPopup(true, '{{group_name}}')" class="button contained w-content" class="button" data-variant="outlined" data-type="icon" data-size="small">
                    <span>Select Users</span>
                    <span class="material-icons-outlined">
                        add
                    </span>
                </button>

                <?php if (!empty($errors["groups[{{group_name}}][group_member]"])) : ?>
                    <small>
                        <?= $errors["groups[{{group_name}}][group_member]"] ?>
                    </small>
                <?php endif; ?>
            </div>
        </div>

        <div id="{{group_name}}-group_members" class="group-members"></div>

        <div class="sub-section">
            <p class="sub-section-title">Allow Access To</p>
            <div class="checkboxes-wrap">
                <label class="checkbox-label">
                    <input type="checkbox" name="groups[{{group_name}}][permissions][budget_permission]" value="true">
                    Budgets
                </label>
                <label class="checkbox-label">
                    <input type="checkbox" name="groups[{{group_name}}][permissions][details_permission]" value="true">
                    Event Details
                </label>
                <label class="checkbox-label">
                    <input type="checkbox" name="groups[{{group_name}}][permissions][registration_permission]" value="true">
                    Registration
                </label>
                <label class="checkbox-label">
                    <input type="checkbox" name="groups[{{group_name}}][permissions][sponsor_permission]" value="true">
                    Sponsors
                </label>
            </div>
        </div>

        <div class="form-section-buttons-wrap">
            <button type="button" onclick="onRemoveGroup('{{group_name}}')" class="icon-button cl-red remove-group-btn">
                <span class="material-icons-outlined">
                    delete
                </span>
            </button>
        </div>
    </div>

    <div class="checkbox-wrap group-member-template">
        <label data-{{group_name}}="{{group_member_id}}" class="checkbox-label">
            {{group_member_name}}
            <input hidden type="checkbox" checked name="groups[{{group_name}}][members][{{group_member_id}}][id]" value="{{group_member_id}}">
            <input hidden type="checkbox" checked name="groups[{{group_name}}][members][{{group_member_id}}][user_id]" value="{{group_member_user_id}}">
            <input hidden type="checkbox" checked name="groups[{{group_name}}][members][{{group_member_id}}][name]" value="{{group_member_name}}">
        </label>
        <span onclick="onRemoveGroupMember(event)" class="material-icons-outlined">
            clear
        </span>
    </div>
</div>

<?php $this->view('includes/header/side-bars/club-dashboard', $menu_side_bar) ?>

<?php $this->view('includes/modals/club/events/users', $select_users) ?>

<script src="<?= ROOT ?>/assets/js/events/edit-event.js"></script>
<script src="<?= ROOT ?>/assets/js/form.js"></script>