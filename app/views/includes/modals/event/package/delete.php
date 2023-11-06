<div class="popup-modal-wrap" popup-name="delete-package">
    <div class="popup-modal">
        <div class="popup-header">
            <span class="title">Delete Package</span>
            <div class="icon" onclick="$(`[popup-name='delete-package']`).popup(false)">
                <span class="material-icons-outlined">
                    close
                </span>
            </div>
        </div>
        <div class="popup-body">
            Are you sure you want to delete this package?
            <form class="form" method="post">
                <input name="id" type="text" hidden>
                <button type="submit" name="submit" value="delete-package" class="button contained">Delete</button>
            </form>
        </div>
    </div>
</div>

<script src="<?= ROOT ?>/assets/js/form.js"></script>