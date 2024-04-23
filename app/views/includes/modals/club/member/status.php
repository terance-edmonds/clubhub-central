<div class="popup-modal-wrap" popup-name="club-member-state">
    <div class="popup-modal">
        <div class="popup-header">
            <span class="title">Club Member State</span>
            <div class="icon" onclick="$(`[popup-name='club-member-state']`).popup(false)">
                <span class="material-icons-outlined">
                    close
                </span>
            </div>
        </div>

        <div class="popup-body">
            <div class="info">
                <p><b>Processing: </b> Member is still under request</p>
                <p><b>Accepted: </b> Member has been accepted</p>
                <p><b>Rejected: </b> Member has been rejected</p>
            </div>
            <form class="form" action="" method="post">
                <input type="text" hidden name="id" value="<?= setValue('id') ?>">
                <div class="input-wrap">
                    <label for="">Event Status</label>
                    <select value="" name="state" id="club-member-state">
                        <option value="" selected disabled hidden>Choose State</option>
                        <option value="PROCESSING">Processing</option>
                        <option value="ACCEPTED">Accepted</option>
                        <option value="REJECTED">Rejected</option>
                    </select>
                    <?php if (!empty($errors["state"])) : ?>
                        <small>
                            <?= $errors["state"] ?>
                        </small>
                    <?php endif; ?>
                </div>

                <button type="submit" name="submit" value="club-member-state" class="button contained">Change</button>
            </form>
        </div>
    </div>
</div>