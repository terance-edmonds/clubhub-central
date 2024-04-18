<div class="popup-modal-wrap" popup-name="apply-membership">
    <div class="popup-modal">
        <div class="popup-header">
            <span class="title">Apply Membership</span>
            <div class="icon" onclick="$(`[popup-name='apply-membership']`).popup(false)">
                <span class="material-icons-outlined">
                    close
                </span>
            </div>
        </div>

        <div class="popup-body">
            <form class="form" method="post">
                <div class="input-wrap">
                    <label for="user_name">Full Name</label>
                    <input value="<?= setValue('user_name') ?>" name="user_name" id="user_name" type="text" placeholder="Full Name" required>
                    <?php if (!empty($errors['user_name'])) : ?>
                        <small><?= $errors['user_name'] ?></small>
                    <?php endif; ?>
                </div>
                <div class="input-wrap">
                    <label for="user_email">Email Address</label>
                    <input value="<?= setValue('user_email') ?>" name="user_email" id="user_email" type="email" placeholder="Email Address" required>
                    <?php if (!empty($errors['user_email'])) : ?>
                        <small><?= $errors['user_email'] ?></small>
                    <?php endif; ?>
                </div>
                <div class="input-wrap">
                    <label for="user_document">Document</label>
                    <input name="user_document" id="user_document" type="file" placeholder="Upload Document">
                    <?php if (!empty($errors['user_document'])) : ?>
                        <small><?= $errors['user_document'] ?></small>
                    <?php endif; ?>
                </div>
                <button type="submit" name="submit" value="apply-membership" class="button contained">Apply</button>
            </form>
        </div>
    </div>
</div>