<div class="popup-modal-wrap" popup-name="event-add-agenda">
    <div class="popup-modal">
        <div class="popup-header">
            <span class="title">Add New Agenda</span>
            <div class="icon" onclick="$(`[popup-name='event-add-agenda']`).popup(false)">
                <span class="material-icons-outlined">
                    close
                </span>
            </div>
        </div>
        <div class="popup-body">
            <form class="form">
                <div class="input-wrap">
                    <label for="agenda_name">Agenda Name</label>
                    <input id="agenda_name" type="text" placeholder="Agenda Name" required>
                </div>
                <div class="input-wrap">
                    <label for="datetime">Date & Time</label>
                    <input id="datetime" type="datetime-local" placeholder="Date & Time" required>
                </div>
                <div class="input-wrap">
                    <label for="location">Location</label>
                    <input id="location" type="text" placeholder="Location">
                </div>

                <button class="button contained">Submit</button>
            </form>
        </div>
    </div>
</div>