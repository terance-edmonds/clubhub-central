<div class="popup-modal-wrap" popup-name="event-status">
    <div class="popup-modal">
        <div class="popup-header">
            <span class="title">Event State</span>
            <div class="icon" onclick="$(`[popup-name='event-status']`).popup(false)">
                <span class="material-icons-outlined">
                    close
                </span>
            </div>
        </div>

        <div class="popup-body">
            <div class="info">
                <p><b>Processing: </b> Event is still under creation process</p>
                <p><b>Active: </b> Event is details are live</p>
                <p><b>De-Active: </b> Event has been closed</p>
            </div>
            <form class="form" action="" method="post">
                <input type="text" hidden name="id" value="<?= setValue('id') ?>">
                <div class="input-wrap">
                    <label for="event-state">Event Status</label>
                    <select value="" name="state" id="event-state">
                        <option value="" selected disabled hidden>Choose State</option>
                        <option value="PROCESSING">Processing</option>
                        <option value="ACTIVE">Active</option>
                        <option value="DEACTIVE">De-Active</option>
                    </select>
                    <?php if (!empty($errors["state"])) : ?>
                        <small>
                            <?= $errors["state"] ?>
                        </small>
                    <?php endif; ?>
                </div>

                <button type="submit" name="submit" value="event-state" class="button contained">Change</button>
            </form>
        </div>
    </div>
</div>