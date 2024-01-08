let page = 1;
let loaded = true;

window.addEventListener('scroll', () => {
    if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 1000) {
        if (loaded) {
            loaded = false;
            page++;
            let params = { page };

            const url = new URL(window.location.href);
            url.pathname = `${url.pathname}/scroll`;
            url.search = new URLSearchParams(params).toString();

            $('.scroll-loader-wrap').attr('data-active', 'true');

            fetch(url.href)
                .then((res) => res.text())
                .then((data) => {
                    const html = $.parseHTML(data);
                    const cards = $(html).filter('.club-post');

                    $('.cards').append(cards);
                })
                .catch((err) => {
                    console.error(err);
                })
                .finally(() => {
                    loaded = true;
                    $('.scroll-loader-wrap').attr('data-active', 'false');
                });
        }
    }
});
