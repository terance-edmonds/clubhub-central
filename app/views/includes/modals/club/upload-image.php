<div class="popup-modal-wrap" popup-name="add-club-gallery">
    <div class="popup-modal">
        <div class="popup-header">
            <span class="title">Upload Image</span>
            <div class="icon" onclick="$(`[popup-name='add-club-gallery']`).popup(false)">
                <span class="material-icons-outlined">
                    close
                </span>
            </div>
        </div>
        <div class="popup-body">
            <form class="form" method="post" enctype="multipart/form-data">
                <?php $this->view('/includes/image-upload', ["name" => "image"]) ?>

                <button type="submit" name="submit" value="upload-image" class="button contained">Upload</button>
            </form>
        </div>
    </div>
</div>