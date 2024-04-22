<div class="popup-modal-wrap user-clubs-modal" popup-name="user-<?= $data['id'] ?>-clubs">
    <div class="popup-modal">
        <div class="popup-header">
            <span class="title">Joined Clubs</span>
            <div class="icon" onclick="$(`[popup-name='user-<?= $data['id'] ?>-clubs']`).popup(false)">
                <span class="material-icons-outlined">
                    close
                </span>
            </div>
        </div>

        <div class="popup-body">
            <div class="clubs-section">
                <?php foreach ($data['clubs'] as $club) { ?>
                    <a href="<?= ROOT ?>/club?id=<?= $club['club_id'] ?>" target="_blank">
                        <div class="card">
                            <img loading="lazy" src="<?= $club['club_image'] ?>" alt="Club Logo" class="club-logo">
                            <div class="details">
                                <div class="text-details">
                                    <p class="title"><?= $club['club_name'] ?></p>
                                    <p class="title"><span class="sub-title"><b>Role:</b> </span><span><?= displayValue($club['club_role'], 'snake_title') ?></span></p>
                                    <p class="title"><span class="sub-title"><b>State:</b> </span><span><?= displayValue($club['club_state'], 'snake_title') ?></span></p>
                                </div>
                                <span class="material-icons-outlined">
                                    chevron_right
                                </span>
                            </div>
                        </div>
                    </a>
                <?php } ?>
            </div>
        </div>
    </div>
</div>