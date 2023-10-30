<div class="popup-modal-wrap" popup-name="edit-expense">
    <div class="popup-modal">
        <div class="popup-header">
            <span class="title">Edit Expense</span>
            <div class="icon" onclick="$(`[popup-name='edit-expense']`).popup(false)">
                <span class="material-icons-outlined">
                    close
                </span>
            </div>
        </div>
        <div class="popup-body">
            <form class="form">
                <input name="id" type="text" hidden>
                <input name="type" type="text" value="EXPENSE" hidden>

                <div class="input-wrap">
                    <label for="name">Name</label>
                    <input id="name" type="text" required>
                </div>
                <div class="input-wrap">
                    <label for="description">Description</label>
                    <textarea class="textarea" id="description" type="text" rows="5" cols="50"></textarea>
                </div>
                <div class="input-wrap">
                    <label for="amount">Amount</label>
                    <input id="amount" type="text" required>
                </div>
                <div class="input-wrap">
                    <label for="to">To</label>
                    <input id="to" type="text" required>
                </div>
                <div class="input-wrap">
                    <label for="payment-type">Payment Type</label>
                    <select name="payment" id="payment-type" class="dd">
                        <option value="CASH" selected>Cash</option>
                        <option value="BANK_TRANSFER">Bank Transfer</option>
                        <option value="CHEQUE">Cheque</option>
                        <option value="CARD">Card</option>
                    </select>
                </div>

                <button name="submit" value="add-expense" class="button contained">Submit</button>
            </form>
        </div>
    </div>
</div>