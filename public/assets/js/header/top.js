const onMenuClick = (e) => {
    const side_menu = $('#nav-menu');

    if (side_menu) {
        let state = side_menu.attr('data-active');

        if (state == 'true') {
            state = false;

            /* enable body scroll */
            $(window).scrollDisable(false);
        } else {
            state = true;

            /* disable body scroll */
            $(window).scrollDisable(true);
        }

        side_menu.attr('data-active', state);
    }
};

window.addEventListener('resize', () => {
    const side_menu = $('#nav-menu');

    if (window.innerWidth >= 1350) {
        if (side_menu) {
            /* enable body scroll */
            $('html, body').css({
                overflow: 'auto',
                height: 'auto'
            });

            side_menu.attr('data-active', 'false');
        }
    }
});
