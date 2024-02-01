<div class="popup-modal-wrap" popup-name="delete-club-post">
    <div class="popup-modal">
        <div class="popup-header">
            <span class="title">Delete Post</span>
            <div class="icon" onclick="$(`[popup-name='delete-club-post']`).popup(false)">
                <span class="material-icons-outlined">
                    close
                </span>
            </div>
        </div>
        <div class="popup-body">
            Are you sure you want to delete this record?
            <form class="form" method="post">
                <input name="id" type="text" hidden>
                <button type="submit" name="submit" value="delete-club-post" class="button contained">Delete</button>
            </form>
        </div>
    </div>
</div>