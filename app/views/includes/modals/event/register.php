<div class="popup-modal-wrap" popup-name="event-register">
    <div class="popup-modal">
        <div class="popup-header">
            <span class="title">Register Now</span>
            <div class="icon" onclick="$(`[popup-name='event-register']`).popup(false)">
                <span class="material-icons-outlined">
                    close
                </span>
            </div>
        </div>
        <div class="popup-body">
            <form class="form" method="post">
                <div class="input-wrap">
                    <label for="full_name">Full Name</label>
                    <input id="full_name" type="text" placeholder="Full Name" required>
                </div>
                <div class="input-wrap">
                    <label for="email">Email Address</label>
                    <input id="email" type="email" placeholder="Email Address" required>
                </div>
                <div class="input-wrap">
                    <label for="contact_number">Contact Number</label>
                    <input id="contact_number" type="text" placeholder="Contact Number" required>
                </div>

                <button type="submit" class="button contained">Submit</button>
            </form>
        </div>
    </div>
</div>

<script src="<?= ROOT ?>/assets/js/form.js"></script>