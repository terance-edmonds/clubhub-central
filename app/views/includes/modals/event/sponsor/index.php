<div class="popup-modal-wrap" popup-name="add-sponsor">
    <div class="popup-modal">
        <div class="popup-header">
            <span class="title">Add New Sponsor</span>
            <div class="icon" onclick="$(`[popup-name='add-sponsor']`).popup(false)">
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
                    <label for="contact_person">Contact Person</label>
                    <input value="<?= setValue('contact_person') ?>" id="contact_person" name="contact_person" type="text" placeholder="Contact Person" required>
                    <?php if (!empty($errors['contact_person'])) : ?>
                        <small><?= $errors['contact_person'] ?></small>
                    <?php endif; ?>
                </div>
                <div class="input-wrap">
                    <label for="contact_number">Contact Number</label>
                    <input value="<?= setValue('contact_number') ?>" id="contact_number" name="contact_number" type="text" placeholder="Contact Number" required>
                    <?php if (!empty($errors['contact_number'])) : ?>
                        <small><?= $errors['contact_number'] ?></small>
                    <?php endif; ?>
                </div>
                <div class="input-wrap">
                    <label for="email">Email</label>
                    <input value="<?= setValue('email') ?>" id="email" name="email" type="email" placeholder="Email" required>
                    <?php if (!empty($errors['email'])) : ?>
                        <small><?= $errors['email'] ?></small>
                    <?php endif; ?>
                </div>
                <div class="input-wrap">
                    <label for="amount">Amount</label>
                    <input value="<?= setValue('amount') ?>" id="amount" name="amount" placeholder="Amount" type="number" min="0" required>
                    <?php if (!empty($errors['amount'])) : ?>
                        <small><?= $errors['amount'] ?></small>
                    <?php endif; ?>
                </div>
                <div class="input-wrap">
                    <label for="package_id">Choose Package</label>
                    <select name="package_id" id="package_id" required>
                        <option value="" selected disabled hidden>Select Package</option>
                        <?php foreach ($select_packages as $package) { ?>
                            <option value="<?= $package->id ?>" <?php if (!empty(setValue('package_id')) and setValue('package_id') == $package->id) { ?> selected <?php } ?>><?= displayValue($package->name) ?></option>
                        <?php } ?>
                    </select>
                    <?php if (!empty($errors['package_id'])) : ?>
                        <small>
                            <?= $errors['package_id'] ?>
                        </small>
                    <?php endif; ?>
                </div>

                <button type="submit" name="submit" value="add-sponsor" class="button contained">Submit</button>
            </form>
        </div>
    </div>
</div>