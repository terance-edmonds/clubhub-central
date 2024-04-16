let page = 1;
let loaded = true;

const onSearch = (e) => {
    const el = $(e.target);
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
        const exists = $(`#selected_members`).find(`:checkbox[value=${el.attr('data-value')}]`);

        el.prop('checked', !!exists.length > 0);
    });

    checkAllState();
};

const checkAllState = () => {
    const check_boxes = $("input[name='user_select_checkbox']").length;
    const checked_boxes = $("input[name='user_select_checkbox']:checked").length;
    $("input[name='select_all_checkbox']").prop('checked', check_boxes == checked_boxes);
};

const onAddMember = (event, email, value) => {
    checkAllState();
    const el = $(event.target);

    if (!el.is(':checked')) {
        const exists = $(`#selected_members`).find(`:checkbox[value=${value}]`);
        exists.parent().parent().remove();
        return;
    }

    /* check if member already added */
    const exists = $(`#selected_members`).find(`:checkbox[value=${value}]`);
    if (exists.length) return;

    /* add new member */
    const selected_member = $('.selected-member-template');
    const clone = selected_member.clone();
    const element = clone
        .html()
        .replaceAll('{{selected_member_email}}', email)
        .replaceAll('{{selected_member_id}}', value);

    clone.html(element).removeClass('selected-member-template').appendTo(`#selected_members`);
};

const onRemoveMember = (e) => {
    $(e.target).parent().remove();
};

var addParamToUrl = (event) => {
    const el = $(event.target);
    page = el.attr('value');

    onSearch({ target: $('#users_search') });
};

const onSelectUsersPopup = (state) => {
    $(`[popup-name='select-event-users']`).popup(state);

    if (state) {
        checkDataState();
    }
};
