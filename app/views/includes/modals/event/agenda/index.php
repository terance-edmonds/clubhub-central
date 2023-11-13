<div class="popup-modal-wrap" popup-name="add-agenda">
    <div class="popup-modal">
        <div class="popup-header">
            <span class="title">Add New Agenda</span>
            <div class="icon" onclick="$(`[popup-name='add-agenda']`).popup(false)">
                <span class="material-icons-outlined">
                    close
                </span>
            </div>
        </div>
        <div class="popup-body">
            <form class="form" method="post">
                <div class="input-wrap">
                    <label for="agenda_name">Agenda Name</label>
                    <input value="<?= setValue('name') ?>" id="agenda_name" name="name" type="text" placeholder="Agenda Name" required>
                    <?php if (!empty($errors['name'])) : ?>
                        <small><?= $errors['name'] ?></small>
                    <?php endif; ?>
                </div>
                <div class="input-wrap">
                    <label for="datetime">Date & Time</label>
                    <input set-min="<?= setValue('datetime') ?>" set-default="datetime" value="<?= setValue('datetime', '', 'datetime') ?>" id="datetime" name="datetime" type="datetime-local" placeholder="Date & Time" required>
                    <?php if (!empty($errors['datetime'])) : ?>
                        <small><?= $errors['datetime'] ?></small>
                    <?php endif; ?>
                </div>
                <div class="input-wrap">
                    <label for="venue">Location</label>
                    <input value="<?= setValue('venue') ?>" id="venue" name="venue" type="text" placeholder="Location">
                    <?php if (!empty($errors['venue'])) : ?>
                        <small><?= $errors['venue'] ?></small>
                    <?php endif; ?>
                </div>
                <div class="input-wrap">
                    <label for="note">Note</label>
                    <textarea id="note" name="note" placeholder="Note"><?= setValue('note') ?></textarea>
                    <?php if (!empty($errors['note'])) : ?>
                        <small><?= $errors['note'] ?></small>
                    <?php endif; ?>
                </div>

                <button type="submit" name="submit" value="create-event-agenda" class="button contained">Submit</button>
            </form>
        </div>
    </div>
</div>