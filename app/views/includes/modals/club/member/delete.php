<div class="popup-modal-wrap" popup-name="delete-club-member">
    <div class="popup-modal">
        <div class="popup-header">
            <span class="title">Delete Member</span>
            <div class="icon" onclick="$(`[popup-name='delete-club-member']`).popup(false)">
                <span class="material-icons-outlined">
                    close
                </span>
            </div>
        </div>
        <div class="popup-body">
            Are you sure you want to delete this member?
            <form class="form" method="post">
                <input name="id" type="text" hidden>
                <button type="submit" name="submit" value="delete-member" class="button contained">Delete</button>
            </form>
        </div>
    </div>
</div>