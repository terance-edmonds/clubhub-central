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

const onAddGroupMember = (e, id, user_id, name) => {
    /* check if member already added */
    let group_name = this.group_name;
    const exists = $(`#${group_name}-group_members`).find(`[data-${group_name}="${id}"]`);

    if (exists.length) return;

    /* add new group member */
    const group_member = $('.group-member-template');
    const clone = group_member.clone();
    const element = clone
        .html()
        .replaceAll('{{group_name}}', group_name)
        .replaceAll('{{group_member_name}}', name)
        .replaceAll('{{group_member_user_id}}', user_id)
        .replaceAll('{{group_member_id}}', id);

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

let page = 1;
let loaded = true;

const onSearch = (e) => {
    const el = $('#users_search');
    const search = el.val();

    if (loaded) {
        loaded = false;
        let params = { page, search, data: 'users_data' };

        const url = new URL(window.location.href);
        url.pathname = `${url.pathname}`;
        url.search = new URLSearchParams(params).toString();

        $('.data-loader-wrap').attr('data-active', 'true');

        fetch(url.href)
            .then((res) => res.text())
            .then((data) => {
                const html = $.parseHTML(data);
                const table = $(html).filter('.table-wrap');

                $('.table-wrap').replaceWith(table);

                /* set the checkbox state */
                checkDataState();
            })
            .catch((err) => {
                console.error(err);
            })
            .finally(() => {
                loaded = true;
                $('.data-loader-wrap').attr('data-active', 'false');
            });
    }
};

const onSelectAll = (event) => {
    const el = $(event.target);
    /* check all the check boxes */
    /* first set the "checked" mark to opposite of the select-all checkbox then trigger a click */
    /* this ensures that all the checkboxes are in one state before click */
    $("input[name='user_select_checkbox']").prop('checked', !el.is(':checked')).trigger('click');
};

/* check if any checkbox data is available in the list if so check the box */
const checkDataState = () => {
    $("input[name='user_select_checkbox']").each(function () {
        const el = $(this);
        const exists = $(`#${this.group_name}-group_members`).find(
            `:checkbox[value=${el.attr('data-value')}]`
        );

        el.prop('checked', !!exists.length > 0);
    });

    checkAllState();
};

const checkAllState = () => {
    const check_boxes = $("input[name='user_select_checkbox']").length;
    const checked_boxes = $("input[name='user_select_checkbox']:checked").length;
    $("input[name='select_all_checkbox']").prop('checked', check_boxes == checked_boxes);
};

const onSelectUsersPopup = (state, group_name) => {
    $(`[popup-name='select-member-users']`).popup(state);

    this.group_name = group_name;
    if (state) {
        checkDataState();
    }
};

$(document).ready(() => {
    if ($('.group-form-section').length === 1) {
        onAddNewGroup();
    }

    onStartEndDatesChange();
});
