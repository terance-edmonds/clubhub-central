<label data-has-image="<?php if (!empty(setValue($name))) echo "true"; ?>" data-cover="<?= $name ?>" class="image-upload">
    <input onchange="onImage(event)" hidden type="file" name="<?= $name ?>">
    <div data-show="<?php if (empty(setValue($name))) echo "true"; ?>" data-label="<?= $name ?>" class="label">
        <span class="material-icons-outlined icon">
            insert_photo
        </span>

        <span class="text">Upload Image File</span>
    </div>

    <img data-show="<?php if (!empty(setValue($name))) echo "true"; ?>" src="<?= setValue($name) ?>" data-image="<?= $name ?>" alt="Preview Image" class="preview-image">

    <?php if (!empty($errors[$name])) : ?>
        <small><?= $errors[$name] ?></small>
    <?php endif; ?>
</label>

<script src="<?= ROOT ?>/assets/js/image-upload.js"></script>