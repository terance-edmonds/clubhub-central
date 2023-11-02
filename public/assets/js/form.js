const onDataPopup = (name, data = {}) => {
    const popup = $(`[popup-name=${name}]`);

    for (const key in data) {
        const input = popup.find(`[name="${key}"]`);
        if (input) {
            input.val(data[key]);
        }
    }

    $(`[popup-name=${name}]`).popup(true);
};

(() => {
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
})();
