let page = 1;
let loaded = true;

const onSearch = (e) => {
    const el = $(e.target);
    const search = el.val();

    if (loaded) {
        loaded = false;
        let params = { page, search };

        const url = new URL(window.location.href);
        url.pathname = `${url.pathname}/data`;
        url.search = new URLSearchParams(params).toString();

        $('.data-loader-wrap').attr('data-active', 'true');

        fetch(url.href)
            .then((res) => res.text())
            .then((data) => {
                const html = $.parseHTML(data);
                const table = $(html).filter('.table-wrap');

                $('.table-wrap').replaceWith(table);
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

const onAddMember = (name, value) => {
    /* reset select */
    $(`#member_select option:first`).prop('selected', true);

    /* check if member already added */
    const exists = $(`#selected_members`).find(`:checkbox[value=${value}]`);
    if (exists.length) return;

    /* add new member */
    const selected_member = $('.selected-member-template');
    const clone = selected_member.clone();
    const element = clone
        .html()
        .replaceAll('{{selected_member_name}}', name)
        .replaceAll('{{selected_member_id}}', value);

    clone.html(element).removeClass('selected-member-template').appendTo(`#selected_members`);
};

const onRemoveMember = (e) => {
    $(e.target).parent().remove();
};
