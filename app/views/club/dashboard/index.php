<head>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/club-dashboard.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/side-bar.css">
</head>

<?php $this->view('includes/header') ?>

<div id="club-dashboard" class="container container-sections side-padding">
    <?php $this->view('includes/side-bars/club/dashboard/left', $menu_data)  ?>

    <section class="center-section">
        <div class="title-bar">
            <div class="title-wrap">
                <span class="title">Events</span>
                <button class="button" data-variant="outlined" data-type="icon" data-size="small">
                    <span>Add Event</span>
                    <span class="material-icons-outlined">
                        add
                    </span>
                </button>
            </div>

            <div class="input-wrap search-input">
                <div class="input">
                    <span class="icon material-icons-outlined">
                        search
                    </span>
                    <input type="text" placeholder="Search">
                </div>
            </div>
        </div>
    </section>
</div>

<?php $this->view('includes/modals/event/register')  ?>
<script src="<?= ROOT ?>/assets/js/events/event.js"></script>