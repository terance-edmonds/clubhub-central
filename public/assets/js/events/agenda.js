/* handle on start and end dates change */
const onStartEndDatesChange = (prefix) => {
    let min = moment().format('yyyy-MM-DDTHH:mm');

    if ($(`#${prefix}_start_datetime`).attr('set-min'))
        min = moment($(`#${prefix}_start_datetime`).attr('set-min')).format('yyyy-MM-DDTHH:mm');

    $(`#${prefix}_start_datetime`).attr('min', min);
    $(`#${prefix}_end_datetime`).attr('min', min);

    $(`#${prefix}_start_datetime`).on('change', function () {
        let start = $(this).val();
        let min = moment(start).format('yyyy-MM-DDTHH:mm');

        if ($(this).attr('set-min'))
            min = moment($(`#${prefix}_start_datetime`).attr('set-min')).format('yyyy-MM-DDTHH:mm');

        $(`#${prefix}_end_datetime`).attr('min', min).val(min);
    });

    $(`#${prefix}_end_datetime`).on('change', function () {
        let end = $(this).val();
        let start = $(`#${prefix}_start_datetime`).val();
        let min = moment(start).format('yyyy-MM-DDTHH:mm');

        if ($(`#${prefix}_start_datetime`).attr('set-min'))
            min = moment($(`#${prefix}_start_datetime`).attr('set-min')).format('yyyy-MM-DDTHH:mm');

        if (start > end) {
            $(this).val(min);
        }
    });
};

$(document).ready(() => {
    onStartEndDatesChange('add');
    onStartEndDatesChange('edit');
});
