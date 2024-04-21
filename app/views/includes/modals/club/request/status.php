<div class="popup-modal-wrap" popup-name="request-status">
    <div class="popup-modal">
        <div class="popup-header">
            <span class="title">Request State</span>
            <div class="icon" onclick="$(`[popup-name='request-status']`).popup(false)">
                <span class="material-icons-outlined">
                    close
                </span>
            </div>
        </div>

        <div class="popup-body">
            <div class="info">
                <p><b>Pending: </b> Request is not taken to consideration</p>
                <p><b>Processing: </b> Request is being processed</p>
                <p><b>Approved: </b> Request has been approved</p>
                <p><b>Reject: </b> Request has been rejected</p>
            </div>
            <form class="form" action="" method="post">
                <input type="text" hidden name="id" value="<?= setValue('id') ?>">
                <div class="input-wrap">
                    <label for="request-state">Request Status</label>
                    <select value="" name="state" id="request-state">
                        <option value="" selected disabled hidden>Choose State</option>
                        <option value="PENDING">Pending</option>
                        <option value="PROCESSING">Processing</option>
                        <option value="APPROVED">Approved</option>
                        <option value="REJECTED">Rejected</option>
                    </select>
                    <?php if (!empty($errors["state"])) : ?>
                        <small>
                            <?= $errors["state"] ?>
                        </small>
                    <?php endif; ?>
                </div>

                <div class="input-wrap">
                    <label for="remarks">Remarks</label>
                    <textarea id="remarks" name="remarks" placeholder="Remarks" required><?= setValue('remarks') ?></textarea>
                    <?php if (!empty($errors['remarks'])) : ?>
                        <small>
                            <?= $errors['remarks'] ?>
                        </small>
                    <?php endif; ?>
                </div>

                <button type="submit" name="submit" value="request-state" class="button contained">Update</button>
            </form>
        </div>
    </div>
</div>