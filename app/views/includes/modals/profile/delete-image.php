<div class="popup-modal-wrap" popup-name="delete-profile-gallery">
    <div class="popup-modal">
        <div class="popup-header">
            <span class="title">Delete Image</span>
            <div class="icon" onclick="$(`[popup-name='delete-profile-gallery']`).popup(false)">
                <span class="material-icons-outlined">
                    close
                </span>
            </div>
        </div>
        <div class="popup-body">
            Are you sure you want to remove this image?
            <form class="form" method="post">
                <input name="id" type="text" hidden>
                <button type="submit" name="submit" value="delete-image" class="button contained">Delete</button>
            </form>
        </div>
    </div>
</div>