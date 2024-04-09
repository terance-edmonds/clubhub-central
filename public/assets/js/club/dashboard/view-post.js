const onViewPost = (data) => {
    const post = $(`[popup-name='view-post']`);
    const datetime = moment(data.created_datetime).fromNow();

    /* set post data */
    post.find('.club-title').text(data.club_name);
    post.find('.club-logo').prop('src', data.club_image);
    post.find('.post-title').text(data.post_name);
    post.find('.description').text(data.description);
    post.find('.datetime').text(datetime);
    post.find('.post-image').prop('src', data.image);

    post.popup(true);
};
