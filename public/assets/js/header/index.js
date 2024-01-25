/* initiate navigation bar selection */
(() => {
    const nav_items = ['home', 'events', 'profile'];
    let pathname = $(location).attr('pathname');
    pathname = pathname.split('/').pop();

    if (!pathname) pathname = 'home';
    for (const key of nav_items) {
        const el = $(`#nav-${key}`);
        if (el) el.attr('data-active', pathname == key);
    }
})();
