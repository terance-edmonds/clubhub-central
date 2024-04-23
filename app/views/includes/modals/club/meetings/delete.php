<div class="popup-modal-wrap" popup-name="delete-club-meeting">
    <div class="popup-modal">
        <div class="popup-header">
            <span class="title">Delete Member</span>
            <div class="icon" onclick="$(`[popup-name='delete-club-meeting']`).popup(false)">
                <span class="material-icons-outlined">
                    close
                </span>
            </div>
        </div>
        <div class="popup-body">
            Are you sure you want to delete this meeting?
            <form class="form" method="post">
                <input name="id" type="text" hidden>
                <button type="submit" name="submit" value="delete-meeting" class="button contained">Delete</button>
            </form>
        </div>
    </div>
</div>