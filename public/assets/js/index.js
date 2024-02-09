$.fn.extend({
    popup: function (show) {
        if (show) {
            $('#overlay').show(50);
            this.slideDown('fast');

            $(window).scrollDisable(true);
        } else {
            $('#overlay').hide();
            this.hide();

            $(window).scrollDisable(false);
        }
    },
    scrollDisable: function (state) {
        console.log(state);
        if (state) {
            /* disable body scroll */
            $('html, body').css({
                overflow: 'hidden',
                height: '100%'
            });
        } else {
            /* enable body scroll */
            $('html, body').css({
                overflow: 'initial',
                height: 'auto'
            });
        }
    }
});

$(document).ready(() => {
    console.log('clubhub central');
});
