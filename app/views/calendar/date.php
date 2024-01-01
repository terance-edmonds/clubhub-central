<head>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/calendar.css">
</head>

<?php $this->view('includes/header') ?>

<div id="calendar" class="container container-sections">
    <div class="center-section">
        <div class="top-bar">
            <a href="<?= ROOT ?>/calendar?<?= $previous_params ?>">
                <button class="icon-wrap">
                    <span class="material-icons">
                        navigate_before
                    </span>
                </button>
            </a>

            <div class="center">
                <p class="month">
                    <?= $month ?>
                </p>
                <p class="year">
                    <?= $year ?>
                </p>
            </div>

            <a href="<?= ROOT ?>/calendar?<?= $next_params ?>">
                <button class="icon-wrap">
                    <span class="material-icons">
                        navigate_next
                    </span>
                </button>
            </a>
        </div>

    </div>
</div>

<?php $this->view('includes/header/bottom') ?>