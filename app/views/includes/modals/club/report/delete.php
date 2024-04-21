<div class="popup-modal-wrap" popup-name="delete-club-report">
    <div class="popup-modal">
        <div class="popup-header">
            <span class="title">Delete Post</span>
            <div class="icon" onclick="$(`[popup-name='delete-club-report']`).popup(false)">
                <span class="material-icons-outlined">
                    close
                </span>
            </div>
        </div>
        <div class="popup-body">
            This action cannot be undone. Are you sure you want to delete this report?
            <form class="form" method="post">
                <input name="id" type="text" hidden>
                <button type="submit" name="submit" value="delete-report" class="button contained">Delete</button>
            </form>
        </div>
    </div>
</div>