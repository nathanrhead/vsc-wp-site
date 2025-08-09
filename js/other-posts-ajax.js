jQuery(function ($) {
  $('.post_other-posts').on('click', '.page-numbers', function (e) {
    e.preventDefault();
    const page = $(this).text().trim() || $(this).data('page');
    const postId = $('.post_other-posts').data('post-id');

    $.ajax({
      url: vscOtherPosts.ajax_url,
      type: 'POST',
      data: {
        action: 'vsc_load_other_posts',
        nonce: vscOtherPosts.nonce,
        paged: page,
        post_id: postId
      },
      success: function (res) {
        $('.post_other-posts').html(res.html);
      }
    });
  });
});