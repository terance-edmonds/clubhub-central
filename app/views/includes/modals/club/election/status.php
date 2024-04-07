<div class="popup-modal-wrap" popup-name="election-status">
    <div class="popup-modal">
        <div class="popup-header">
            <span class="title">Update Status</span>
            <div class="icon" onclick="$(`[popup-name='election-status']`).popup(false)">
                <span class="material-icons-outlined">
                    close
                </span>
            </div>
        </div>

        <div class="popup-body">
            <div class="info">
                <p><b>Pending: </b> Election is still processing</p>
                <p><b>Ready: </b> Publish election details to the voters</p>
                <p><b>Open: </b> Publish election to vote</p>
                <p><b>Close: </b> Election voting has stopped</p>
            </div>

            <form class="form" action="" method="post">
                <input type="text" hidden name="id" value="<?= setValue('id') ?>">
                <div class="input-wrap">
                    <label for="election-state">Election Status</label>
                    <select value="" name="state" id="election-state">
                        <option value="" selected disabled>Choose State</option>
                        <option value="PENDING">Pending</option>
                        <option value="READY">Ready</option>
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