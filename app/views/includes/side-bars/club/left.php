<section class="side-bar club-side-bar">
    <div class="inner-section no-border profile-section">
        <div class="profile-details">
            <img src="<?= $club["image"] ?>" alt="Club Image" class="image">

            <div class="details">
                <span class="name"><?= $club["name"] ?></span>
                <p class="desc"><?= $club["description"] ?></p>
            </div>
        </div>
        <button onclick="$(`[popup-name='apply-membership']`).popup(true)" class="button">
            Apply Membership
        </button>
    </div>

    <div class="inner-section">
        <div class="title-wrap">
            <p class="title">Event Calendar</p>
        </div>

        <div class="content">
            <?php $this->view('includes/calendar', $calendar_data) ?>
        </div>
    </div>
</section>

<?php $this->view("includes/modals/club") ?>

<script>
    <?php if (!empty($popups["add-$tab"])) { ?>
        $(`[popup-name='apply-membership']`).popup(true)
    <?php } ?>
</script>