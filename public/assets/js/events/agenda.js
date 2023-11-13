const onDateChange = () => {
    let min = moment().format('yyyy-MM-DDTHH:mm');

    if ($('#datetime').attr('set-min'))
        min = moment($('#datetime').attr('set-min')).format('yyyy-MM-DDTHH:mm');

    $('#datetime').attr('min', min);
};

$(document).ready(() => {
    onDateChange();
});
