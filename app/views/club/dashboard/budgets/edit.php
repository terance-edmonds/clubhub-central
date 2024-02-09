<head>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/side-bar.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/dashboard.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/club-dashboard.css">
</head>

<?php $this->view('includes/header') ?>

<?php $this->view('includes/alerts') ?>

<div id="club-dashboard-budget-edit" class="container container-sections side-padding club-dashboard dashboard-container">
    <?php $this->view('includes/side-bars/club/dashboard/left', $left_bar) ?>

    <section class="center-section no-padding">
        <div class="title-bar set-padding">
            <div class="title-wrap">
                <span class="title">Edit Event Budgets</span>
            </div>
        </div>

        <div class="content-section">
            <div class="form">
                <div class="form-section">
                    <p class="form-section-title">General Details</p>
                    <div class="form-section-content">
                        <div class="multi-wrap">
                            <div class="input-wrap">
                                <label for="name">Event Name</label>
                                <input readonly value="<?= $event_data->name ?>" id="name" type="text" name="name" placeholder="Event Name">
                            </div>
                            <div class="input-wrap">
                                <label for="venue">Venue</label>
                                <input readonly value="<?= $event_data->venue ?>" id="venue" type="text" name="venue" placeholder="Venue">
                            </div>
                        </div>
                        <div class="multi-wrap">
                            <div class="input-wrap">
                                <label readonly for="start_datetime">Start Date & Time</label>
                                <input set-default="datetime" value="<?= $event_data->start_datetime ?>" id="start_datetime" type="datetime-local" name="start_datetime" placeholder="Start Date & Time">
                            </div>
                            <div class="input-wrap">
                                <label for="end_datetime">End Date & Time</label>
                                <input readonly set-default="datetime" value="<?= $event_data->end_datetime ?>" id="end_datetime" type="datetime-local" name="end_datetime" placeholder="End Date & Time">
                            </div>
                        </div>
                    </div>

                    <div class="input-wrap">
                        <label for="description">Description</label>
                        <textarea readonly id="description" name="description" placeholder="Description"><?= $event_data->description ?></textarea>
                    </div>
                </div>
            </div>

            <form class="form" method="post">
                <div class="form-section budgets">
                    <div id="event-budgets-section" class="form-section-title-wrap">
                        <p class="form-section-title">Budget Details</p>
                        <div onclick="onAddNewBudget()" class="button" data-variant="outlined" data-type="icon" data-size="small">
                            <span>Add New</span>
                            <span class="material-icons-outlined">
                                add
                            </span>
                        </div>
                    </div>

                    <?php if (!empty($_POST['budgets'])) { ?>
                        <?php foreach ($_POST['budgets'] as $key => $budget) { ?>
                            <div id="<?= $key ?>" class="form-section-content budget-form-section">
                                <div class="multi-wrap">
                                    <div class="input-wrap">
                                        <label for="<?= $key ?>-name">Budget Name</label>
                                        <input value="<?= setValue("budgets[$key][name]") ?>" id="<?= $key ?>-name" type="text" name="budgets[<?= $key ?>][name]" placeholder="Budget Name" required>
                                        <?php if (!empty($errors["budgets[$key][name]"])) : ?>
                                            <small>
                                                <?= $errors["budgets[$key][name]"] ?>
                                            </small>
                                        <?php endif; ?>
                                    </div>
                                    <div class="input-wrap">
                                        <label for="<?= $key ?>-budget">Budget</label>
                                        <input value="<?= setValue("budgets[$key][amount]") ?>" id="<?= $key ?>-budget" type="number" name="budgets[<?= $key ?>][amount]" placeholder="Budget" min="0" required>
                                        <?php if (!empty($errors["budgets[$key][amount]"])) : ?>
                                            <small>
                                                <?= $errors["budgets[$key][amount]"] ?>
                                            </small>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="form-section-buttons-wrap">
                                    <button type="button" onclick="onRemoveBudget('<?= $key ?>')" class="icon-button cl-red remove-budget-btn">
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
                    <button type="submit" name="submit" value="update_budget" class="button contained">Update</button>
                </div>
            </form>
        </div>
    </section>


    <div id="{{budget_name}}" class="form-section-content budget-template budget-form-section">
        <div class="multi-wrap">
            <div class="input-wrap">
                <label for="{{budget_name}}-name">Budget Name</label>
                <input value="<?= setValue("budgets[{{budget_name}}][name]") ?>" id="{{budget_name}}-name" type="text" name="budgets[{{budget_name}}][name]" placeholder="Budget Name" required>
                <?php if (!empty($errors["budgets[{{budget_name}}][name]"])) : ?>
                    <small>
                        <?= $errors["budgets[{{budget_name}}][name]"] ?>
                    </small>
                <?php endif; ?>
            </div>
            <div class="input-wrap">
                <label for="{{budget_name}}-budget">Budget</label>
                <input value="<?= setValue("budgets[{{budget_name}}][amount]") ?>" id="{{budget_name}}-budget" type="number" name="budgets[{{budget_name}}][amount]" placeholder="Budget" min="0" required>
                <?php if (!empty($errors["budgets[{{budget_name}}][amount]"])) : ?>
                    <small>
                        <?= $errors["budgets[{{budget_name}}][amount]"] ?>
                    </small>
                <?php endif; ?>
            </div>
        </div>

        <div class="form-section-buttons-wrap">
            <button type="button" onclick="onRemoveBudget('{{budget_name}}')" class="icon-button cl-red remove-budget-btn">
                <span class="material-icons-outlined">
                    delete
                </span>
            </button>
        </div>
    </div>
</div>

<?php $this->view('includes/header/side-bars/club-dashboard', $menu_side_bar) ?>

<script src="<?= ROOT ?>/assets/js/club/dashboard/edit-budget.js"></script>
<script src="<?= ROOT ?>/assets/js/form.js"></script>