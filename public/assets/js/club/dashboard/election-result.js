$(document).ready(() => {
    $('.progress').each(function () {
        const progress = $(this).data('progress');
        $(this).find('.progress-bar').css('width', `${progress}%`);
    });
});
