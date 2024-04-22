const showError = (type, message) => {
    $(`#${type}-error`).text(message).fadeIn();
    setTimeout(() => {
        $(`#${type}-error`).text('').fadeOut();
    }, 3000);
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

let page = 1;
let loaded = true;

const onFilterPercentage = () => {
    if ($('input[name="filter_event_percentage"]').is(':checked')) {
        onSearch();
    }
};

const onSearch = (e) => {
    const el = $('#users_search');
    const search = el.val();

    if (loaded) {
        loaded = false;
        let params = { page, search, data: 'users_data' };

        if ($('input[name="filter_event_percentage"]').is(':checked')) {
            params['filter_event_percentage'] = $('#filter_event_percentage').val();
        }

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
        const exists = $(`#${this.current_type}-users`).find(
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

const onAddMember = (event, id, user_id, name) => {
    checkAllState();

    const type = this.current_type;
    const other_types =
        type == 'voter'
            ? ['president_candidate', 'secretary_candidate', 'treasurer_candidate']
            : ['voter'];
    const group_id = new Date().getTime().toString();

    /* check if member already added on the given type */
    const exists = $(`#${type}-users`)
        .find(`[data-${type}="${id}"]`)
        .find(`:checkbox[value="${id}"]`);

    if (exists.length) {
        // showError(type, 'User already added');
        return;
    }

    /* check if the member is already added on the other type */
    for (const other_type of other_types) {
        const other_exists = $(`#${other_type}-users`)
            .find(`[data-${other_type}="${id}"]`)
            .find(`:checkbox[value="${id}"]`);

        if (other_exists.length) {
            showError(type, 'Each user can be added only to one category');
            return;
        }
    }

    /* add new group member */
    const user = $(`.user-template`);
    const clone = user.clone();
    const element = clone
        .html()
        .replaceAll('{{type}}', type)
        .replaceAll('{{group_id}}', group_id)
        .replaceAll(`{{user_name}}`, name)
        .replaceAll(`{{user_user_id}}`, user_id)
        .replaceAll(`{{user_id}}`, id);

    clone.html(element).removeClass('user-template').appendTo(`#${type}-users`);
};

const onRemoveMember = (e) => {
    $(e.target).parent().remove();
};

var addParamToUrl = (event) => {
    const el = $(event.target);
    page = el.attr('value');

    onSearch({ target: $('#users_search') });
};

const onSelectUsersPopup = (state, current_type) => {
    $(`[popup-name='select-member-users']`).popup(state);

    this.current_type = current_type;
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
