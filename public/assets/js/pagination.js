var addParamToUrl = (event) => {
    const el = $(event.target);
    const page = el.attr('value');
    const name = el.attr('name');

    const searchParams = new URLSearchParams(window.location.search);
    searchParams.set(name, page);
    window.location.search = searchParams.toString();
};
