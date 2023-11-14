<div class="popup-modal-wrap" popup-name="add-package">
    <div class="popup-modal">
        <div class="popup-header">
            <span class="title">Add Package</span>
            <div class="icon" onclick="$(`[popup-name='add-package']`).popup(false)">
                <span class="material-icons-outlined">
                    close
                </span>
            </div>
        </div>

        <div class="popup-body">
            <form class="form" method="POST">

                <div class="input-wrap">
                    <label for="name">Name</label>
                    <input value="<?= setValue('name') ?>" id="name" name="name" type="text" placeholder="Name" required>
                    <?php if (!empty($errors['name'])) : ?>
                        <small><?= $errors['name'] ?></small>
                    <?php endif; ?>
                </div>
                <div class="input-wrap">
                    <label for="amount">Amount</label>
                    <input value="<?= setValue('amount') ?>" id="amount" name="amount" type="number" min="0" required>
                    <?php if (!empty($errors['amount'])) : ?>
                        <small><?= $errors['amount'] ?></small>
                    <?php endif; ?>
                </div>

                <button type="submit" name="submit" value="add-package" class="button contained">Submit</button>
            </form>
        </div>
    </div>
</div>