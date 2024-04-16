let page = 1;
let loaded = true;

$('#chat-box').on('scroll', function () {
    if (Math.abs($(this).scrollTop()) + $(this).innerHeight() >= $(this)[0].scrollHeight - 20) {
        if (loaded) {
            loaded = false;
            page++;
            let params = { page };

            const url = new URL(window.location.href);
            url.pathname = `${url.pathname}/scroll`;
            url.search = new URLSearchParams(params).toString();

            $('.chat-scroll-loader-wrap').attr('data-active', 'true');

            fetch(url.href)
                .then((res) => res.text())
                .then((data) => {
                    const html = $.parseHTML(data);
                    const messages = $(html).filter('.text-wrap');

                    $('#chat-box').append(messages);
                })
                .catch((err) => {
                    console.error(err);
                })
                .finally(() => {
                    loaded = true;
                    $('.chat-scroll-loader-wrap').attr('data-active', 'false');
                });
        }
    }
});

function onComment(e) {
    /* prevent form from submitting */
    e.preventDefault();

    fetch(window.location.href, {
        method: 'POST',
        body: new FormData(e.target)
    })
        .then((res) => res.text())
        .then((data) => {
            // console.log(data);
        })
        .catch((err) => {
            console.error(err);
        })
        .finally(() => {
            const button = $(e.target).find('[type="submit"]');
            button.attr('data-loading', 'false');
        });
}
