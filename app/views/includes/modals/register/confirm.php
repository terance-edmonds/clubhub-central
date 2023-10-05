<div class="popup-modal" popup-name="register-confirm">
    <div class="popup-header">
        <span class="title">Welcome To ClubHub</span>
        <div class="icon" onclick="$(`[popup-name='register-confirm']`).popup(false)">
            <span class="material-icons-outlined">
                close
            </span>
        </div>
    </div>
    <div class="popup-body">
        <div class="note">A verification link has been sent to your email. Please use it to verify your account.</div>
        <a href="<?= ROOT ?>/login">
            <button class="button contained">
                OK
            </button>
        </a>
    </div>
</div>