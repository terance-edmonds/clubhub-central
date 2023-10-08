/* reset form inputs */
const resetFormInput = () => {
    $('input').on('input', function (e) {
        $(e.target).parent().find('small').hide();
    });
};

$(window).on('load', function () {
    resetFormInput();
});
