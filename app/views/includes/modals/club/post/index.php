<div class="popup-modal-wrap" popup-name="view-post">
    <div class="popup-modal" popup-size='m'>
        <div class="popup-header">
            <span class="title">View Post</span>
            <div class="icon" onclick="$(`[popup-name='view-post']`).popup(false)">
                <span class="material-icons-outlined">
                    close
                </span>
            </div>
        </div>

        <div class="popup-body cards">
            <?php $this->view('includes/club-post', ["data" => (object) [
                "club_image" => "",
                "club_name" => "",
                "club_id" => "",
                "post_name" => "",
                "created_datetime" => "",
                "description" => "",
                "image" => ""
            ]]) ?>
        </div>
    </div>
</div>

<script src="<?= ROOT ?>/assets/js/cards.js"></script>