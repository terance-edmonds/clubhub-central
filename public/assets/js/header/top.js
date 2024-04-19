const localPath = 'chc/public';

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

$('.notification-item').on('click', function () {
    const el = $(this);

    if (el.attr('data-unread') == 'true') {
        el.attr('data-unread', false);

        const url = new URL(window.location.origin);
        /* for development */
        if (url.hostname === 'localhost') url.pathname = `${url.pathname}/${localPath}`;

        url.pathname = `${url.pathname}/notification/read`;

        const form_data = new FormData();
        form_data.append('id', el.attr('data-notification'));

        fetch(url.href, {
            method: 'POST',
            body: form_data
        })
            .then((res) => res.text())
            .then((data) => {
                // console.log(data);
            })
            .catch((err) => {
                console.error(err);
            });
    }

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

    if ($(`div[data-unread="true"]`).length > 0) {
        if ($('.notification-icon-wrap').find('.icon-wrap').find('.active').length == 0) {
            $('.notification-icon-wrap').find('.icon-wrap').append('<div class="active"></div>');
        }
    } else {
        $('.notification-icon-wrap').find('.icon-wrap').find('.active').remove();
    }

    if (el.hasClass('active')) {
        $('.notification-list').fadeOut();
    } else {
        $('.notification-list').css('display', 'flex').hide().fadeIn();
    }
    el.toggleClass('active');
};

const onDeleteNotification = (e, id) => {
    const url = new URL(window.location.origin);
    /* for development */
    if (url.hostname === 'localhost') url.pathname = `${url.pathname}/${localPath}`;

    url.pathname = `${url.pathname}/notification/delete`;

    const form_data = new FormData();
    form_data.append('id', id);

    fetch(url.href, {
        method: 'POST',
        body: form_data
    })
        .then((res) => res.text())
        .then((data) => {
            $(`div[data-notification="${id}"]`).remove();

            if ($(`div[data-notification]`).length === 0) {
                $('.notification-list').append(
                    ` <div class="notification-item empty"><p class="title">No Notifications.</p></div>`
                );
            }
        })
        .catch((err) => {
            console.error(err);
        });
};
