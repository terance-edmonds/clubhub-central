const onImage = (e) => {
    const [file] = e.target.files;

    if (file) {
        $(`[data-cover='${e.target.name}']`).attr('data-has-image', 'true');

        $(`[data-label='${e.target.name}']`).attr('data-show', 'false');

        $(`[data-image='${e.target.name}']`)
            .attr('data-show', 'true')
            .attr('src', URL.createObjectURL(file));
    }
};
