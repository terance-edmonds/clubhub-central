<div class="popup-modal-wrap" popup-name="delete-club-request">
    <div class="popup-modal">
        <div class="popup-header">
            <span class="title">Delete Request</span>
            <div class="icon" onclick="$(`[popup-name='delete-club-request']`).popup(false)">
                <span class="material-icons-outlined">
                    close
                </span>
            </div>
        </div>
        <div class="popup-body">
            This action cannot be undone. Are you sure you want to delete this record?
            <form class="form" method="post">
                <input name="id" type="text" hidden>
                <button type="submit" name="submit" value="delete-request" class="button contained">Delete</button>
            </form>
        </div>
    </div>
</div>