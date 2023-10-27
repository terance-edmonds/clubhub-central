/* initiate menu bar selection */
(() => {
    const menu_item = [
        'events',
        'registrations',
        'sponsors',
        'budgets',
        'agendas',
        'notifications',
        'complains'
    ];
    let pathname = $(location).attr('pathname');
    pathname = pathname.split('/').pop();

    if (pathname === 'dashboard') pathname = 'events';
    for (const key of menu_item) {
        const el = $(`#menu-item-${key}`);
        if (el) el.attr('data-active', pathname == key);
    }
})();
