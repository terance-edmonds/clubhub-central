const onDataPopup = (name, data = {}) => {
    const popup = $(`[popup-name=${name}]`);

    for (const key in data) {
        const input = popup.find(`[name="${key}"]`);
        if (input) {
            input.val(data[key]);

            if (input.filter('[set-min]').length > 0) {
                input.attr('set-min', data[key]);
            }
        }
    }

    $(`[popup-name=${name}]`).popup(true);
};

const onViewPopup = (title, description) => {
    const popup = $(`[popup-name='view-text']`);

    popup.find('[name="title"]').text(title);
    popup.find('[name="description"]').text(description);
    $(`[popup-name='view-text']`).popup(true);
};

/* set default values for inputs */
const setDefaultInputValues = () => {
    const inputs = $(`[set-default]`);

    for (const input of inputs) {
        const obj = $(input);

        if (obj.attr('set-default') == 'datetime') {
            obj.val(moment().format('yyyy-MM-DDTHH:mm'));
        }
        if (obj.attr('set-default') == 'date') {
            obj.val(moment().format('yyyy-MM-DD'));
        }
        if (obj.attr('set-default') == 'time') {
            obj.val(moment().format('HH:mm'));
        }
    }
};

/* set button to loading state after submission */
const setButtonLoading = () => {
    const forms = $('form');

    forms.each(function () {
        const form = $(this);

        form.on('submit', function (event) {
            const button = $(this).find('[type="submit"]');

            button.attr('data-loading', 'true');
        });
    });
};

(() => {
    setDefaultInputValues();
    setButtonLoading();
})();
