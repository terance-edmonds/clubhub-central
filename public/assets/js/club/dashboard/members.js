let page = 1;
let loaded = true;

const onSearch = (e) => {
    const el = $('#users_search');
    const search = el.val();

    if (loaded) {
        loaded = false;
        let params = { page, member_search: search, data: 'users_data', tab: 'administrators' };

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

const onSelectMember = (e) => {
    /* prevent form from submitting */
    e.preventDefault();

    const formData = new FormData(e.target);
    formData.append('role', this.current_role);
    formData.append('submit', 'update-admin-member');

    const button = $(e.target).find('[type="submit"]');
    button.attr('data-loading', 'true');

    fetch(window.location.href, {
        method: 'POST',
        body: formData
    })
        .then((res) => res.text())
        .then((data) => {
            // console.log(data);
            // var newWindow = window.open();
            // newWindow.document.write(data);

            window.location.reload();
        })
        .catch((err) => {
            console.error(err);
        })
        .finally(() => {
            const button = $(e.target).find('[type="submit"]');
            button.attr('data-loading', 'false');
        });
};

const onSelectUsersPopup = (state, current_role) => {
    this.current_role = current_role;

    $(`[popup-name='select-club-member-users']`).popup(state);
};

var addParamToUrl = (event) => {
    const el = $(event.target);
    page = el.attr('value');

    onSearch({ target: $('#users_search') });
};
