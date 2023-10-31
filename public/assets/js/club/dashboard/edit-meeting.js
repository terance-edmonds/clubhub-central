const onAddMember = (e) => {
    const option_value = $(`#member_select`).val();
    const name = $(`#member_select option:eq(${option_value})`).text();

    /* reset select */
    $(`#member_select option:first`).prop('selected', true);

    /* check if member already added */
    const exists = $(`#selected_members`).find(`:checkbox[value=${option_value}]`);
    if (exists.length) return;

    /* add new member */
    const selected_member = $('.selected-member-template');
    const clone = selected_member.clone();
    const element = clone
        .html()
        .replaceAll('{{selected_member_name}}', name)
        .replaceAll('{{selected_member_id}}', option_value);

    clone.html(element).removeClass('selected-member-template').appendTo(`#selected_members`);
};

const onRemoveMember = (e) => {
    $(e.target).parent().remove();
};
