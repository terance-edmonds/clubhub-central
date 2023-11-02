<div class="popup-modal-wrap" popup-name="add-vote">
    <div class="popup-modal">
        <div class="popup-header">
            <span class="title">Election Name</span>
            <div class="icon" onclick="$(`[popup-name='add-vote']`).popup(false)">
                <span class="material-icons-outlined">
                    close
                </span>
            </div>
        </div>
        <div class="popup-body">
            <form class="form">
                <div class="input-wrap">
                    <label for="president">President</label>
                    <input id="president" type="text" required>
                </div>
                <div class="input-wrap">
                    <label for="secretory">Secretory</label>
                    <input id="secretory" type="text" placeholder="Date & Time" required>
                </div>
                <div class="input-wrap">
                    <label for="treasurer">Treasurer</label>
                    <input id="treasurer" type="text" placeholder="Location">
                </div>

                <button class="button contained">Submit</button>
            </form>
        </div>
    </div>
</div>