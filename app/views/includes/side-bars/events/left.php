<section class="side-bar">
    <div class="inner-section no-border">
        <div class="input-wrap">
            <div class="input">
                <span class="icon material-icons-outlined">
                    search
                </span>
                <input type="text" placeholder="Search">
            </div>
        </div>
    </div>

    <div class="inner-section">
        <div class="title-wrap">
            <p class="title">Event Filter</p>
            <span class="icon material-icons-outlined">
                tune
            </span>
        </div>

        <div class="content filter-checkboxes">
            <div class="checkbox-wrap">
                Sports Tournament
            </div>
            <div class="checkbox-wrap" data-active="true">
                Musical
            </div>
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