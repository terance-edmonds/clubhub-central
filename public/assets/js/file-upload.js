const onFile = (e) => {
    const [file] = e.target.files;

    if (file) {
        const target = $(e.target).parent();
        target.find('.upload-text').text('File Uploaded');
        target.find('.file-name').text(file?.name);

        target.attr('data-uploaded', 'true');
    }
};
