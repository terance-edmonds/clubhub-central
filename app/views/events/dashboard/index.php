<head>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/side-bar.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/dashboard.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/event-dashboard.css">
</head>

<?php $this->view('includes/header') ?>

<div id="event-dashboard-event-edit" class="container container-sections side-padding event-dashboard dashboard-container">
    <?php $this->view('includes/side-bars/events/dashboard/left', ["menu" => $menu])  ?>

    <section class="center-section no-padding">
        <div class="title-bar set-padding">
            <div class="title-wrap">
                <span class="title">Event Details</span>

            </div>
        </div>

        <div class="content-section">
            <form class="form" method="post">
                <?php $this->view('/includes/image-upload', ["name" => "image"]) ?>

                <div class="form-section">
                    <p class="form-section-title">General Details</p>
                    <div class="form-section-content">
                        <div class="multi-wrap">
                            <div class="input-wrap">
                                <label for="name">Event Name</label>
                                <input value="<?= setValue('name') ?>" id="name" type="text" name="name" placeholder="Event Name" required>
                                <?php if (!empty($errors['name'])) : ?>
                                    <small><?= $errors['name'] ?></small>
                                <?php endif; ?>
                            </div>
                            <div class="input-wrap">
                                <label for="venue">Venue</label>
                                <input value="<?= setValue('venue') ?>" id="venue" type="text" name="venue" placeholder="Venue" required>
                                <?php if (!empty($errors['venue'])) : ?>
                                    <small><?= $errors['venue'] ?></small>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="multi-wrap">
                            <div class="input-wrap">
                                <label for="start_datetime">Start Date & Time</label>
                                <input value="" id="start_datetime" type="datetime-local" name="start_datetime" placeholder="Start Date & Time" required>
                                <?php if (!empty($errors['start_datetime'])) : ?>
                                    <small><?= $errors['start_datetime'] ?></small>
                                <?php endif; ?>
                            </div>
                            <div class="input-wrap">
                                <label for="end_datetime">End Date & Time</label>
                                <input value="<?= setValue('end_datetime') ?>" id="end_datetime" type="datetime-local" name="end_datetime" placeholder="End Date & Time" required>
                                <?php if (!empty($errors['end_datetime'])) : ?>
                                    <small><?= $errors['end_datetime'] ?></small>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <p class="form-section-title">Other Details</p>
                    <div class="form-section-content">
                        <div class="input-wrap">
                            <label for="description">Description</label>
                            <textarea value="<?= setValue('description') ?>" id="description" name="description" placeholder="Description" required></textarea>
                            <?php if (!empty($errors['description'])) : ?>
                                <small><?= $errors['description'] ?></small>
                            <?php endif; ?>
                        </div>

                        <label class="checkbox-label">
                            <span>Open For External Registrations</span>

                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </label>
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

                </div>

                <div class="buttons-wrap">
                    <button type="submit" class="button contained">Save Event</button>
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
                    <small><?= $errors["groups[{{group_name}}][name]"] ?></small>
                <?php endif; ?>
            </div>
            <div class="input-wrap">
                <label for="{{group_name}}-group_member_select">Group Members</label>
                <select onchange="onAddGroupMember(event, '{{group_name}}')" value="" name="{{group_name}}-group_member_select" id="{{group_name}}-group_member_select">
                    <option value="" selected disabled hidden>Choose Member</option>
                    <option value="1">Terance</option>
                    <option value="2">Raguram</option>
                </select>
                <?php if (!empty($errors['venue'])) : ?>
                    <small><?= $errors['venue'] ?></small>
                <?php endif; ?>
            </div>
        </div>

        <div id="{{group_name}}-group_members" class="group-members"></div>

        <div class="sub-section">
            <p class="sub-section-title">Allow Access To</p>
            <div class="checkboxes-wrap">
                <label class="checkbox-label">
                    <input type="checkbox" name="groups[{{group_name}}][access][]" value="allow_budget_access">
                    Budgets
                </label>
                <label class="checkbox-label">
                    <input type="checkbox" name="groups[{{group_name}}][access][]" value="allow_event_details_access">
                    Event Details
                </label>
                <label class="checkbox-label">
                    <input type="checkbox" name="groups[{{group_name}}][access][]" value="allow_registration_access">
                    Registration
                </label>
                <label class="checkbox-label">
                    <input type="checkbox" name="groups[{{group_name}}][access][]" value="allow_sponsors_access">
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
        <label class="checkbox-label">
            {{group_member_name}}
            <input hidden type="checkbox" checked name="groups[{{group_name}}][members][]" value="{{group_member_id}}">
        </label>
        <span onclick="onRemoveGroupMember(event)" class="material-icons-outlined">
            clear
        </span>
    </div>
</div>

<script src="<?= ROOT ?>/assets/js/events/edit-event.js"></script>
<script src="<?= ROOT ?>/assets/js/form.js"></script>