<div class="popup-modal-wrap" popup-name="delete-event-register">
    <div class="popup-modal">
        <div class="popup-header">
            <span class="title">Delete Registration</span>
            <div class="icon" onclick="$(`[popup-name='delete-event-register']`).popup(false)">
                <span class="material-icons-outlined">
                    close
                </span>
            </div>
        </div>
        <div class="popup-body">
            Are you sure you want to delete this record?
            <form class="form" method="post">
                <input name="id" type="text" hidden>
                <button type="submit" name="submit" value="delete-event-register" class="button contained">Delete</button>
            </form>
        </div>
    </div>
</div>