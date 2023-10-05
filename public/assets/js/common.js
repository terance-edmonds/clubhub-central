$(window).on('load', function () {
    /* reset form inputs */
    $('input').on('input', function (e) {
        $(e.target).parent().find('small').hide();
    });
});
