const onMenuClick = (e) => {
    const side_menu = $('#nav-menu');

    if (side_menu) {
        let state = side_menu.attr('data-active');

        if (state == 'true') {
            state = false;
        } else {
            state = true;
        }

        side_menu.attr('data-active', state);
    }
};

window.addEventListener('resize', () => {
    const side_menu = $('#nav-menu');

    if (window.innerWidth >= 1350) {
        if (side_menu) side_menu.attr('data-active', 'false');
    }
});
