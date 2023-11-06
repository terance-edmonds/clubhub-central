<div class="popup-modal-wrap" popup-name="edit-sponsor">
    <div class="popup-modal">
        <div class="popup-header">
            <span class="title">Edit Sponsor</span>
            <div class="icon" onclick="$(`[popup-name='edit-sponsor']`).popup(false)">
                <span class="material-icons-outlined">
                    close
                </span>
            </div>
        </div>

        <div class="popup-body">
            <form class="form" method="POST">
                <input name="id" type="text" hidden>
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
                    <input value="<?= setValue('email') ?>" id="email" name="email" type="text" placeholder="Email" required>
                    <?php if (!empty($errors['email'])) : ?>
                        <small><?= $errors['email'] ?></small>
                    <?php endif; ?>
                </div>
                <div class="input-wrap">
                    <label for="amount">Amount</label>
                    <input value="<?= setValue('amount') ?>" id="amount" name="amount" type="text" placeholder="Amount" required>
                    <?php if (!empty($errors['amount'])) : ?>
                        <small><?= $errors['amount'] ?></small>
                    <?php endif; ?>
                </div>
                <!-- <div class="input-wrap">
                    <label for="sponsor_type">Sponsor Type</label>
                    <input id="sponsor_type" type="text" placeholder="Sponsor Type" required>
                </div>
                <div class="input-wrap">
                    <label for="package">Package</label>
                    <input id="package" type="text" placeholder="Package" required>
                </div> -->

                <button type="submit" name="submit" value="edit-sponsor" class="button contained">Submit</button>
            </form>
        </div>
    </div>
</div>

<script src="<?= ROOT ?>/assets/js/form.js"></script>