<?php
$side_bar_user = new User();
$side_bar_auth_user_id = Auth::getId();
$side_bar_user = $side_bar_user->one(["id" => $side_bar_auth_user_id]);
?>

<section class="side-bar profile-side-bar">
    <div class="inner-section no-border profile-section">
        <img src="<?php echo (!empty($side_bar_user->image)) ? $side_bar_user->image : ROOT . '/assets/images/other/empty-profile.jpg' ?>" alt="Profile Image" class="image">

        <div class="details">
            <span class="name"><?= $side_bar_user->first_name ?> <?= $side_bar_user->last_name ?></span>
            <p class="desc"><?= $side_bar_user->description ?></p>
        </div>
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