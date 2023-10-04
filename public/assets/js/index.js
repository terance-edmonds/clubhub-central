$.fn.extend({
    popup: function (show) {
        if (show) {
            $('#overlay').show(50);
            this.show('fast');
        } else {
            $('#overlay').hide();
            this.hide();
        }
    }
});

$(document).ready(() => {
    console.log('clubhub central');
});
