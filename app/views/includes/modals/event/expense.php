<div class="popup-modal" popup-name="add-expense">
    <div class="popup-header">
        <span class="title">Add New Expense</span>
        <div class="icon" onclick="$(`[popup-name='add-expense']`).popup(false)">
            <span class="material-icons-outlined">
                close
            </span>
        </div>
    </div>
    <div class="popup-body">
        <form class="form">
            <div class="input-wrap">
                <label for="name">Name</label>
                <input id="name" type="text"  required>
            </div>
            <div class="input-wrap">
                <label for="description">Description</label>
                <textarea  class ="textarea"id="description" type="text" rows="5" cols="50"></textarea>
            </div>
            <div class="input-wrap">
                <label for="amount">Amount</label>
                <input id="amount" type="text"  required>
            </div>
            <div class="input-wrap">
                <label for="to">To</label>
                <input id="to" type="text"  required>
            </div>
            <div class="input-wrap">
                <label for="payment-type">Payment Type</label>
                <select name="payment" id="payment-type" class="dd">
                    <option value="cash">Cash</option>
                    <option value="cheque">Cheque</option>
                    <option value="online">Online</option>
                </select>
            </div>



            <button class="button contained">Submit</button>
        </form>
    </div>
</div>