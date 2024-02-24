const onReadMore = (event) => {
    const read_more = $(event.target);
    const description = read_more.parent().find('.description');

    if (description) {
        description.toggleClass('truncate-text');

        if (read_more.text() == 'Read More') {
            read_more.text('Read Less');
        } else {
            read_more.text('Read More');
        }
    }
};
