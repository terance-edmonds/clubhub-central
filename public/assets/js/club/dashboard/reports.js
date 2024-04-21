const onSubmit = (e) => {
    /* prevent form from submitting */
    e.preventDefault();

    const formData = new FormData(e.target);
    formData.append('submit', 'generate-report');

    fetch(window.location.href, {
        method: 'POST',
        body: formData
    });
    /* .then((res) => res.text())
        .then((data) => {
            console.log(data);
            var newWindow = window.open();
            newWindow.document.write(data);
        })
        .catch((err) => {
            console.error(err);
        })
        .finally(() => {
            const button = $(e.target).find('[type="submit"]');
            button.attr('data-loading', 'false');
        }); */

    window.location.assign(window.location.href.replace('/add', ''));
};
