<div class="popup-modal-wrap" popup-name="election-status">
    <div class="popup-modal">
        <div class="popup-header">
            <span class="title">View Post</span>
            <div class="icon" onclick="$(`[popup-name='election-status']`).popup(false)">
                <span class="material-icons-outlined">
                    close
                </span>
            </div>
        </div>

        <div class="popup-body">
            <form class="form" action="" method="post">
                <input type="text" hidden name="id" value="<?= setValue('id') ?>">
                <div class="input-wrap">
                    <label for="election-state">Event Status</label>
                    <select value="" name="state" id="election-state">
                        <option value="" selected disabled hidden>Choose State</option>
                        <option value="OPEN">Open</option>
                        <option value="CLOSED">Closed</option>
                    </select>
                    <?php if (!empty($errors["state"])) : ?>
                        <small>
                            <?= $errors["state"] ?>
                        </small>
                    <?php endif; ?>
                </div>

                <button type="submit" name="submit" value="election-state" class="button contained">Change</button>
            </form>
        </div>
    </div>
</div>