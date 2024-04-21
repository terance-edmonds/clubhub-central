const resetGroupAttributes = () => {
    const groups = $('.group-form-section');

    if (groups.length === 2) {
        groups.each(function () {
            $(this).find('.remove-group-btn').prop('disabled', true);
        });
    } else {
        groups.each(function () {
            $(this).find('.remove-group-btn').prop('disabled', false);
        });
    }
};

const onAddNewGroup = () => {
    const group = $('.group-template');
    const clone = group.clone();
    const group_name = new Date().getTime().toString();
    const element = clone.html().replaceAll('{{group_name}}', group_name);

    clone
        .html(element)
        .attr('id', group_name)
        .removeClass('group-template')
        .insertAfter('#event-groups-section');

    resetGroupAttributes();
};

const onAddGroupMember = (e, group_name) => {
    const option_value = $(`#group_member_select-${group_name}`).val();
    const name = $(`#group_member_select-${group_name} option[value="${option_value}"]`).text();
    const values = option_value.split(',');

    /* reset select */
    $(`#group_member_select-${group_name} option:first`).prop('selected', true);

    /* check if member already added */
    const exists = $(`#${group_name}-group_members`)
        .find(`:checkbox[name*='[id]']`)
        .find(`:checkbox[value="${values[0]}"]`);

    if (exists.length) return;

    /* add new group member */
    const group_member = $('.group-member-template');
    const clone = group_member.clone();
    const element = clone
        .html()
        .replaceAll('{{group_name}}', group_name)
        .replaceAll('{{group_member_name}}', name)
        .replaceAll('{{group_member_user_id}}', values[1])
        .replaceAll('{{group_member_id}}', values[0]);

    clone
        .html(element)
        .removeClass('group-member-template')
        .appendTo(`#${group_name}-group_members`);
};

const onRemoveGroupMember = (e) => {
    $(e.target).parent().remove();
};

const onRemoveGroup = (group_name) => {
    const groups = $('.group-form-section');
    if (groups.length !== 1) {
        $(`#${group_name}`).remove();
    }

    resetGroupAttributes();
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
