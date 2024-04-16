<head>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/side-bar.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/dashboard.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/club-dashboard.css">
</head>

<?php $this->view('includes/header') ?>

<?php $this->view('includes/alerts') ?>

<div id="club-dashboard-community" class="container container-sections side-padding club-dashboard dashboard-container">
    <?php $this->view('includes/side-bars/club/dashboard/left', $left_bar) ?>

    <section class="center-section">
        <div class="title-bar">
            <div class="title-wrap">
                <span class="title">Community Chat</span>
            </div>
        </div>

        <div class="content-section">
            <div id="chat-box" class="chat-box">
                <?php if (count($messages) == 0) { ?>
                    <div class="text-wrap">No Messages</div>
                <?php } ?>
                <?php foreach ($messages as $record) {
                ?>
                    <div class="text-wrap">
                        <span class="name"><b><?= $record->name ?></b></span>
                        <p class="text"><?= $record->message ?></p>
                        <span class="datetime">
                            <script>
                                document.write(moment('<?= $record->created_datetime ?>').tz(Intl.DateTimeFormat().resolvedOptions().timeZone).format('yyyy-MM-DD hh:mm a'));
                            </script>
                        </span>
                    </div>
                <?php } ?>

                <div class="chat-scroll-loader-wrap" data-active="false">
                    <div class="scroll-loader">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>

            <form class="chat-form" action="" method="post">
                <div class="input-wrap">
                    <label for="message">Add a Comment</label>
                    <input set-default="datetime" readonly value="<?= setValue('created_datetime') ?>" type="datetime-local" name="created_datetime" required hidden>
                    <input value="<?= setValue('message') ?>" id="message" type="text" name="message" placeholder="Comment.." required>
                    <?php if (!empty($errors['message'])) : ?>
                        <small>
                            <?= $errors['message'] ?>
                        </small>
                    <?php endif; ?>
                </div>
                <button type="submit" class="button" data-type="icon" data-size="small">
                    <span class="material-icons-outlined">
                        send
                    </span>
                </button>
            </form>
        </div>
    </section>
</div>

<?php $this->view('includes/header/side-bars/club-dashboard', $menu_side_bar) ?>

<script src="<?= ROOT ?>/assets/js/form.js"></script>
<script src="<?= ROOT ?>/assets/js/club/dashboard/community-chat.js"></script>