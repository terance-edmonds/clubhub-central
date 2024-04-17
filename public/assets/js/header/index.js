/* initiate navigation bar selection */
(() => {
    const nav_items = ['home', 'events', 'profile'];
    let pathname = $(location).attr('pathname');
    pathname = pathname.split('/').pop();

    if (!pathname) pathname = 'home';
    for (const key of nav_items) {
        const el = $(`.nav-${key}`);
        if (el) el.attr('data-active', pathname == key);
    }
})();

$('.notification-item').on('click', function () {
    const el = $(this);
    el.attr('data-unread', false);

    el.toggleClass('active');

    if (el.hasClass('active')) {
        /* description */
        el.find('.description').removeClass('truncate-text');

        /* buttons */
        el.find('.buttons').css({
            display: 'none',
            opacity: 0,
            height: 'auto'
        });
        el.find('.buttons').fadeIn(function () {
            $(this).animate({ opacity: 1 }).css({ display: 'flex' });
        });
    } else {
        /* description */
        el.find('.description').addClass('truncate-text');

        /* buttons */
        el.find('.buttons').fadeOut(function () {
            $(this).animate({ opacity: 0 }).css({ display: 'none' });
        });
    }

    /* title */
    el.find('.title').css({
        display: 'none',
        opacity: 0,
        height: 'auto'
    });
    el.find('.title').slideDown(function () {
        $(this).animate({ opacity: 1 });
    });

    /* description */
    el.find('.description').css({
        display: 'none',
        opacity: 0,
        height: 'auto'
    });
    el.find('.description').slideDown(function () {
        $(this).animate({ opacity: 1 });
    });
});

const onNotificationsClick = (e) => {
    const el = $('.notification-icon-wrap');

    if (el.hasClass('active')) {
        $('.notification-list').fadeOut();
    } else {
        $('.notification-list').css('display', 'flex').hide().fadeIn();
    }
    el.toggleClass('active');
};
