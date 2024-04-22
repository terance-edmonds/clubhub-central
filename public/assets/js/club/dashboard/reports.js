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

/* handle on start and end dates change */
const onStartEndDatesChange = (prefix) => {
    $(`#${prefix}_start`).on('change', function () {
        let start = $(this).val();
        let end = $(`#${prefix}_end`).val();
        let min = moment(start).format('yyyy-MM-DD');

        if ($(this).attr('set-min'))
            min = moment($(`#${prefix}_start`).attr('set-min')).format('yyyy-MM-DD');

        $(`#${prefix}_end`).attr('min', min);

        if (start > end) {
            $(`#${prefix}_end`).attr('min', min).val(min);
        }
    });

    $(`#${prefix}_end`).on('change', function () {
        let end = $(this).val();
        let start = $(`#${prefix}_start`).val();
        let min = moment(start).format('yyyy-MM-DD');

        if ($(`#${prefix}_start`).attr('set-min'))
            min = moment($(`#${prefix}_start`).attr('set-min')).format('yyyy-MM-DD');

        if (start > end) {
            $(this).val(min);
        }
    });
};

$(document).ready(() => {
    const prefixes = ['events_datetime', 'users_datetime'];

    for (const prefix of prefixes) {
        onStartEndDatesChange(prefix);
    }
});
