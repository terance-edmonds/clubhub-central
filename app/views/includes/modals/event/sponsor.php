<div class="popup-modal" popup-name="add-sponsor">
    <div class="popup-header">
        <span class="title">Add New Sponsor</span>
        <div class="icon" onclick="$(`[popup-name='add-sponsor']`).popup(true)">
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
                <label for="contact_person">Contact Person</label>
                <input id="contact_person" type="email" placeholder="Contact Person" required>
            </div>
            <div class="input-wrap">
                <label for="contact_number">Contact Number</label>
                <input id="contact_number" type="text" placeholder="Contact Number" required>
            </div>
            <div class="input-wrap">
                <label for="email">Email</label>
                <input id="email" type="text" placeholder="Email" required>
            </div>
            <div class="input-wrap">
                <label for="amount">Amount</label>
                <input id="amount" type="text" placeholder="Amount" required>
            </div>
            <div class="input-wrap">
                <label for="sponsor_type">Sponsor Type</label>
                <input id="sponsor_type" type="text" placeholder="Sponsor Type" required>
            </div>
            <div class="input-wrap">
                <label for="package">Package</label>
                <input id="package" type="text" placeholder="Package" required>
            </div>

            <button class="button contained">Submit</button>
        </form>
    </div>
</div>