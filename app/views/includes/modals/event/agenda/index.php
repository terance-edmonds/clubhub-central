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
                    <label for="add_start_datetime">Start Date & Time</label>
                    <input set-min="<?= setValue('start_datetime') ?>" set-default="datetime" value="<?= setValue('start_datetime', '', 'datetime') ?>" id="add_start_datetime" name="start_datetime" type="datetime-local" placeholder="Start Date & Time" required>
                    <?php if (!empty($errors['start_datetime'])) : ?>
                        <small><?= $errors['start_datetime'] ?></small>
                    <?php endif; ?>
                </div>
                <div class="input-wrap">
                    <label for="add_end_datetime">End Date & Time</label>
                    <input set-min="<?= setValue('end_datetime') ?>" set-default="datetime" value="<?= setValue('end_datetime', '', 'datetime') ?>" id="add_end_datetime" name="end_datetime" type="datetime-local" placeholder="End Date & Time" required>
                    <?php if (!empty($errors['end_datetime'])) : ?>
                        <small><?= $errors['end_datetime'] ?></small>
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