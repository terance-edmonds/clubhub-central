<?php
$auth_user_id = Auth::getId();
$user = new User();

$user_data = $user->one(["id" => $auth_user_id]);
$_POST['user_name'] = $user_data->first_name . " " . $user_data->last_name;
$_POST['user_email'] = $user_data->email;
?>

<div class="popup-modal-wrap apply-membership-modal" popup-name="apply-membership">
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
            <form class="form" method="post" enctype="multipart/form-data">
                <div class="input-wrap">
                    <label for="user_name">Full Name</label>
                    <input readonly value="<?= setValue('user_name') ?>" name="user_name" id="user_name" type="text" placeholder="Full Name" required>
                    <?php if (!empty($errors['user_name'])) : ?>
                        <small><?= $errors['user_name'] ?></small>
                    <?php endif; ?>
                </div>
                <div class="input-wrap">
                    <label for="user_email">Email Address</label>
                    <input readonly value="<?= setValue('user_email') ?>" name="user_email" id="user_email" type="email" placeholder="Email Address" required>
                    <?php if (!empty($errors['user_email'])) : ?>
                        <small><?= $errors['user_email'] ?></small>
                    <?php endif; ?>
                </div>
                <div class="input-wrap">
                    <label class="file-upload">
                        <input onchange="onFile(event)" name="user_document" type="file" placeholder="Upload Document" hidden>
                        <div class="on-upload">
                            <span class="material-icons-outlined icon">
                                upload_file
                            </span>
                            <span class="text upload-text">Upload File</span>
                            <span class="f-14 file-name">( Optional )</span>
                        </div>
                    </label>
                    <?php if (!empty($errors['user_document'])) : ?>
                        <small><?= $errors['user_document'] ?></small>
                    <?php endif; ?>
                </div>

                <input set-default="datetime" value="<?= setValue('created_datetime') ?>" id="created_datetime" type="datetime-local" name="created_datetime" required hidden>
                <button type="submit" name="submit" value="apply-membership" class="button contained">Apply</button>
            </form>
        </div>
    </div>
</div>

<script src="<?= ROOT ?>/assets/js/file-upload.js"></script>