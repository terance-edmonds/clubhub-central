<div class="popup-modal-wrap" popup-name="delete-user">
    <div class="popup-modal">
        <div class="popup-header">
            <span class="title">Delete User</span>
            <div class="icon" onclick="$(`[popup-name='delete-user']`).popup(false)">
                <span class="material-icons-outlined">
                    close
                </span>
            </div>
        </div>
        <div class="popup-body">
            Are you sure you want to delete this user?
            <form class="form" method="post">
                <input name="id" type="text" hidden>
                <button type="submit" name="submit" value="delete-user" class="button contained">Delete</button>
            </form>
        </div>
    </div>
</div>