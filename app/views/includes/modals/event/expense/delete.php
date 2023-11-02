<div class="popup-modal-wrap" popup-name="delete-expense">
    <div class="popup-modal">
        <div class="popup-header">
            <span class="title">Delete Income</span>
            <div class="icon" onclick="$(`[popup-name='delete-expense']`).popup(false)">
                <span class="material-icons-outlined">
                    close
                </span>
            </div>
        </div>
        <div class="popup-body">
            Are you sure you want to delete this expense details?
            <form class="form" method="post">
                <input name="id" type="text" hidden>
                <button name="submit" value="delete-expense" class="button contained">Delete</button>
            </form>
        </div>
    </div>
</div>