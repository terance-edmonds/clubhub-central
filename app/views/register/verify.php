<head>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/register-verify.css">
</head>

<div id="register-verify" class="full-container">
    <?php if ($is_verified) { ?>
        <section class="section">
            <div class="icon">
                <span class="material-icons-outlined">
                    check_circle
                </span>
            </div>
            <div class="text-wrap">
                <h1 class="title">Verified!</h1>
                <div class="desc">
                    You have successfully verified your account
                </div>
            </div>

            <a href="<?= ROOT ?>/login"><button class="button">OK</button></a>
        </section>
    <?php } else { ?>
        <section class="section">
            <div class="icon error">
                <span class="material-icons-outlined">
                    cancel
                </span>
            </div>
            <div class="desc">
                We're sorry, but we couldn't verify your account at this time. Please double-check your information and try again. If you continue to experience issues, please contact our support team for assistance. We apologize for any inconvenience.
            </div>

            <a href="<?= ROOT ?>/login"><button class="button">OK</button></a>
        </section>
    <?php } ?>
</div>

<script src="<?= ROOT ?>/assets/js/common.js"></script>