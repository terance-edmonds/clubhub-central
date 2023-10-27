<label data-cover="<?php echo $name ?>" class="image-upload">
    <input onchange="onImage(event)" hidden type="file" name="<?php echo $name ?>">
    <div data-label="<?php echo $name ?>" class="label">
        <span class="material-icons-outlined icon">
            insert_photo
        </span>

        <span class="text">Upload Image File</span>
    </div>

    <img src="" data-image="<?php echo $name ?>" alt="Preview Image" class="preview-image">
</label>

<script src="<?= ROOT ?>/assets/js/image-upload.js"></script>