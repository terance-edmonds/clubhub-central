<section class="side-bar profile-side-bar">
    <div class="inner-section no-border profile-section">
        <img src="https://picsum.photos/100/100" alt="Profile Image" class="image">

        <div class="details">
            <span class="name">Terance Edmonds</span>
            <p class="desc">Bio Description here!</p>
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