<div class="popup-modal-wrap" popup-name="add-complain">
    <div class="popup-modal">
        <div class="popup-header">
            <span class="title">Add New Complain</span>
            <div class="icon" onclick="$(`[popup-name='add-complain']`).popup(false)">
                <span class="material-icons-outlined">
                    close
                </span>
            </div>
        </div>
        <div class="popup-body">
            <form class="form" method="post">
                <div class="input-wrap">
                    <label for="complain">Complain</label>
                    <textarea id="complain" name="complain" placeholder="Note"><?= setValue('complain') ?></textarea>
                    <?php if (!empty($errors['complain'])) : ?>
                        <small><?= $errors['complain'] ?></small>
                    <?php endif; ?>
                </div>

                <button type="submit" name="submit" value="create-event-complain" class="button contained">Submit</button>
            </form>
        </div>
    </div>
</div>