<div class="popup-modal-wrap" popup-name="delete-sponsor">
    <div class="popup-modal">
        <div class="popup-header">
            <span class="title">Delete Sponsor</span>
            <div class="icon" onclick="$(`[popup-name='delete-sponsor']`).popup(false)">
                <span class="material-icons-outlined">
                    close
                </span>
            </div>
        </div>
        <div class="popup-body">
            Are you sure you want to delete this sponsor?
            <form class="form" method="post">
                <input name="id" type="text" hidden>
                <button type="submit" name="submit" value="delete-sponsor" class="button contained">Delete</button>
            </form>
        </div>
    </div>
</div>

<script src="<?= ROOT ?>/assets/js/form.js"></script>