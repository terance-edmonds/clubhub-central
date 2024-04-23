const init = () => {
    let min_date = moment().format('yyyy-MM-DD');
    $('#date').attr('min', min_date).val(min_date);

    let min_time = moment().format('HH:00');
    let min_end_time = moment(min_time, 'HH:mm').add('h', 1).format('HH:mm');

    $('#start_time').attr('min', min_time).val(min_time);
    $('#end_time').attr('min', min_end_time).val(min_end_time);
};

const onStartEndTimesChange = () => {
    let min = moment().format('HH:00');

    $('#start_time').attr('min', min);
    $('#end_time').attr('min', min);

    $('#start_time').on('change', function () {
        let start = $(this).val();
        let end = $('#end_time').val();
        let now = moment().format('HH:mm');
        let min = start;

        if (now > start) {
            min = now;
            start = min;
            $(this).val(min);
        }

        if (moment.duration(moment(end, 'HH:mm').diff(moment(start, 'HH:mm'))).asHours() < 1) {
            min = moment(min, 'HH:mm').add('h', 1).format('HH:mm');
        }

        $('#end_time').attr('min', min).val(min);
    });

    $('#end_time').on('change', function () {
        let end = $(this).val();
        let start = $('#start_time').val();
        let min = start;

        if (start > end) {
            min = moment(start, 'HH:mm').add('h', 1).format('HH:mm');
            $(this).val(min);
        }
    });
};

$(document).ready(() => {
    onStartEndTimesChange();
    init();
});
