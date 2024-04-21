<section class="side-bar profile-side-bar">
    <div class="inner-section no-border profile-section">
        <img src="<?php echo (!empty($user->image)) ? $user->image : ROOT . '/assets/images/other/empty-profile.jpg' ?>" alt="Profile Image" class="image">

        <div class="details">
            <span class="name"><?= $user->first_name ?> <?= $user->last_name ?></span>
            <p class="desc"><?= $user->description ?></p>
        </div>
    </div>
</section>