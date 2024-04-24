<section class="side-bar">
    <div class="inner-section no-border">
        <form method="get" class="search-input">
            <div class="input-wrap">
                <div class="input">
                    <button type="submit" class="icon-button">
                        <span class="icon material-icons-outlined">
                            search
                        </span>
                    </button>
                    <input type="text" placeholder="Search" name="search" value="<?= setValue('search', '', 'text', 'get') ?>">
                </div>
            </div>
        </form>
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