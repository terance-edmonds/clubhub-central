<div class="popup-modal-wrap" popup-name="event-register">
    <div class="popup-modal">
        <div class="popup-header">
            <span class="title">Register Now</span>
            <div class="icon" onclick="$(`[popup-name='event-register']`).popup(false)">
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
                    <label for="user_contact">Contact Number</label>
                    <input value="<?= setValue('user_contact') ?>" name="user_contact" id="user_contact" type="text" placeholder="Contact Number" required>
                    <?php if (!empty($errors['user_contact'])) : ?>
                        <small><?= $errors['user_contact'] ?></small>
                    <?php endif; ?>
                </div>

                <button type="submit" name="submit" value="event_registration" class="button contained">Submit</button>
            </form>
        </div>
    </div>
</div>