const onImage = (e) => {
    const [file] = e.target.files;

    if (file) {
        $(`[data-cover='${e.target.name}']`).addClass('no-border');

        $(`[data-label='${e.target.name}']`).hide();

        $(`[data-image='${e.target.name}']`).show().attr('src', URL.createObjectURL(file));
    }
};
