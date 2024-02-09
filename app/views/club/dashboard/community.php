<head>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/side-bar.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/dashboard.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/club-dashboard.css">
</head>

<?php $this->view('includes/header') ?>

<div id="club-dashboard-community" class="container container-sections side-padding club-dashboard dashboard-container">
    <?php $this->view('includes/side-bars/club/dashboard/left', $left_bar) ?>

    <section class="center-section">
        <div class="title-bar">
            <div class="title-wrap">
                <span class="title">Community Chat</span>
            </div>
        </div>

        <div class="content-section">
            <div class="chat-box">
                <div class="text-wrap">
                    <p class="text">Lorem ipsum dolor sit amet.</p>
                </div>
                <div class="text-wrap">
                    <p class="text">Lorem ipsum dolor sit amet.</p>
                </div>
                <div class="text-wrap">
                    <p class="text">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Placeat ex aut, quam ad
                        iste quisquam, perspiciatis delectus laborum cum, maiores eveniet tempore excepturi a expedita
                        vel quasi enim quas repudiandae.</p>
                </div>
            </div>
            <form class="chat-form" action="" method="post">
                <div class="input-wrap">
                    <label for="name">Add a Comment</label>
                    <input value="<?= setValue('name') ?>" id="name" type="text" name="name" placeholder="Comment.." required>
                    <?php if (!empty($errors['name'])) : ?>
                        <small>
                            <?= $errors['name'] ?>
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
<?php $this->view('includes/header/bottom') ?>

<script src="<?= ROOT ?>/assets/js/form.js"></script>