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
