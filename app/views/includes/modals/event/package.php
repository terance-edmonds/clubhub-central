<div class="popup-modal" popup-name="add-package">
    <div class="popup-header">
        <span class="title">Register Now</span>
        <div class="icon" onclick="$(`[popup-name='add-package']`).popup(false)">
            <span class="material-icons-outlined">
                close
            </span>
        </div>
    </div>
    <div class="popup-body">
        <form class="form">
            <div class="input-wrap">
                <label for="name">Name</label>
                <input id="name" type="text" placeholder="Name" required>
            </div>
            <div class="input-wrap">
                <label for="amount">Amount</label>
                <input id="amount" type="email" placeholder="Amount" required>
            </div>

            <button class="button contained">Submit</button>
        </form>
    </div>
</div>