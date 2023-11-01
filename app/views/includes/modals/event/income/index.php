<div class="popup-modal-wrap" popup-name="add-income">
    <div class="popup-modal">
        <div class="popup-header">
            <span class="title">Add New Income</span>
            <div class="icon" onclick="$(`[popup-name='add-income']`).popup(false)">
                <span class="material-icons-outlined">
                    close
                </span>
            </div>
        </div>

        <div class="popup-body">
            <form class="form" method="post">
                <input name="type" type="text" value="INCOME" hidden>

                <div class="input-wrap">
                    <label for="name">Name</label>
                    <input value="<?= setValue('name') ?>" id="name" name="name" type="text" required>
                    <?php if (!empty($errors['name'])) : ?>
                        <small><?= $errors['name'] ?></small>
                    <?php endif; ?>
                </div>
                <div class="input-wrap">
                    <label for="description">Description</label>
                    <textarea class="textarea" name="description" id="description" type="text" rows="5" cols="50"><?= setValue('description') ?></textarea>
                    <?php if (!empty($errors['description'])) : ?>
                        <small><?= $errors['description'] ?></small>
                    <?php endif; ?>
                </div>
                <div class="input-wrap">
                    <label for="amount">Amount</label>
                    <input value="<?= setValue('amount') ?>" id="amount" name="amount" type="number" min="0" required>
                    <?php if (!empty($errors['amount'])) : ?>
                        <small><?= $errors['amount'] ?></small>
                    <?php endif; ?>
                </div>
                <div class="input-wrap">
                    <label for="third_party">From</label>
                    <input value="<?= setValue('third_party') ?>" id="third_party" name="third_party" type="text" required>
                    <?php if (!empty($errors['third_party'])) : ?>
                        <small><?= $errors['third_party'] ?></small>
                    <?php endif; ?>
                </div>
                <div class="input-wrap">
                    <label for="payment-type">Payment Type</label>
                    <select value="<?= setValue('payment_type') ?>" name="payment_type" id="payment-type">
                        <option value="CASH" selected>Cash</option>
                        <option value="BANK_TRANSFER">Bank Transfer</option>
                        <option value="CHEQUE">Cheque</option>
                        <option value="CARD">Card</option>
                    </select>
                    <?php if (!empty($errors['payment_type'])) : ?>
                        <small><?= $errors['payment_type'] ?></small>
                    <?php endif; ?>
                </div>

                <button name="submit" value="add-income" class="button contained">Submit</button>
            </form>
        </div>
    </div>
</div>