const onAddUser = (e, type) => {
    const option_value = $(`#${type}`).val();
    const name = $(`#${type} option[value="${option_value}"]`).text();
    const values = option_value.split(',');

    /* reset select */
    $(`#${type} option:first`).prop('selected', true);

    /* check if member already added */
    const exists = $(`#${type}-users`).find(`:checkbox[value="${values[0]}"]`);
    if (exists.length) return;

    /* add new group member */
    const user = $(`.user-template`);
    const clone = user.clone();
    const element = clone
        .html()
        .replaceAll('{{type}}', type)
        .replaceAll(`{{user_name}}`, name)
        .replaceAll(`{{user_user_id}}`, values[1])
        .replaceAll(`{{user_id}}`, values[0]);

    clone.html(element).removeClass('user-template').appendTo(`#${type}-users`);
};

const onRemoveUser = (e) => {
    $(e.target).parent().remove();
};

/* handle on start and end dates change */
const onStartEndDatesChange = () => {
    let min = moment().format('yyyy-MM-DDTHH:mm');

    if ($('#start_datetime').attr('set-min'))
        min = moment($('#start_datetime').attr('set-min')).format('yyyy-MM-DDTHH:mm');

    $('#start_datetime').attr('min', min);
    $('#end_datetime').attr('min', min);

    $('#start_datetime').on('change', function () {
        let start = $(this).val();
        let min = moment(start).format('yyyy-MM-DDTHH:mm');

        if ($(this).attr('set-min'))
            min = moment($('#start_datetime').attr('set-min')).format('yyyy-MM-DDTHH:mm');

        $('#end_datetime').attr('min', min).val(min);
    });

    $('#end_datetime').on('change', function () {
        let end = $(this).val();
        let start = $('#start_datetime').val();
        let min = moment(start).format('yyyy-MM-DDTHH:mm');

        if ($('#start_datetime').attr('set-min'))
            min = moment($('#start_datetime').attr('set-min')).format('yyyy-MM-DDTHH:mm');

        if (start > end) {
            $(this).val(min);
        }
    });
};

$(document).ready(() => {
    if ($('.group-form-section').length === 1) {
        onAddNewGroup();
    }

    onStartEndDatesChange();
});