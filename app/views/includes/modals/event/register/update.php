<div class="popup-modal-wrap" popup-name="event-register-update">
    <div class="popup-modal">
        <div class="popup-header">
            <span class="title">Update Details</span>
            <div class="icon" onclick="$(`[popup-name='event-register-update']`).popup(false)">
                <span class="material-icons-outlined">
                    close
                </span>
            </div>
        </div>
        <div class="popup-body">
            <form class="form" method="post">
                <input value="<?= setValue('id') ?>" name="id" id="id" type="text" hidden required>
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

                <label class="checkbox-label">
                    <span>Mark as Attended</span>

                    <label class="switch">
                        <input <?php if (in_array(setValue('attended'), ['1', 'on'])) { ?> checked <?php } ?> type="checkbox" name="attended">
                        <span class="slider"></span>
                    </label>
                </label>

                <button type="submit" name="submit" value="event_registration_update" class="button contained">Save</button>
            </form>
        </div>
    </div>
</div>