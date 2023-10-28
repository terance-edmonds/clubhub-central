$.fn.extend({
    popup: function (show) {
        if (show) {
            $('#overlay').show(50);
            this.slideDown('fast');

            /* disable body scroll */
            $('html, body').css({
                overflow: 'hidden',
                height: '100%'
            });
        } else {
            $('#overlay').hide();
            this.hide();

            /* enable body scroll */
            $('html, body').css({
                overflow: 'auto',
                height: 'auto'
            });
        }
    }
});

$(document).ready(() => {
    console.log('clubhub central');
});
