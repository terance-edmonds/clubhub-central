<div class="popup-modal-wrap" popup-name="event-budget-incharge-reject">
    <div class="popup-modal">
        <div class="popup-header">
            <span class="title">Reject Budget</span>
            <div class="icon" onclick="$(`[popup-name='event-budget-incharge-reject']`).popup(false)">
                <span class="material-icons-outlined">
                    close
                </span>
            </div>
        </div>

        <div class="popup-body">
            <form class="form" action="" method="post">
                <div class="input-wrap">
                    <label for="remarks">Remarks</label>
                    <textarea id="remarks" name="remarks" placeholder="Remarks" required><?= setValue('remarks') ?></textarea>
                    <?php if (!empty($errors['remarks'])) : ?>
                        <small>
                            <?= $errors['remarks'] ?>
                        </small>
                    <?php endif; ?>
                </div>

                <button type="submit" name="submit" value="reject-incharge-budgets" class="button contained">Reject</button>
            </form>
        </div>
    </div>
</div>