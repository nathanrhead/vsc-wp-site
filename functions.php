<?php
// Enqueue parent and child styles
add_action('wp_enqueue_scripts', function () {
  wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
  wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/style.css', ['parent-style'], filemtime(get_stylesheet_directory() . '/style.css'));
});

// Enqueue custom JavaScript.
function responsive_child_enqueue_scripts() {
  wp_enqueue_script(
    'responsive-child-custom-js',
    get_stylesheet_directory_uri() . '/custom.js',
    array('jquery'),
    filemtime(get_stylesheet_directory() . '/custom.js'), // Cache-busting
    true // Load in footer
  );
}
add_action('wp_enqueue_scripts', 'responsive_child_enqueue_scripts');

// Register a custom post type for books.
function register_book_post_type() {
  $labels = array(
    'name'               => 'Books',
    'singular_name'      => 'Book',
    'menu_name'          => 'Books',
    'name_admin_bar'     => 'Book',
    'add_new'            => 'Add New',
    'add_new_item'       => 'Add New Book',
    'new_item'           => 'New Book',
    'edit_item'          => 'Edit Book',
    'view_item'          => 'View Book',
    'all_items'          => 'All Books',
    'search_items'       => 'Search Books',
    'parent_item_colon'  => 'Parent Books:',
    'not_found'          => 'No books found.',
    'not_found_in_trash' => 'No books found in Trash.',
  );

  $args = array(
    'labels'             => $labels,
    'public'             => true,
    'has_archive'        => true,
    'rewrite'            => array('slug' => 'book'),
    'show_in_rest'       => true, // Enable Gutenberg and REST API
    'supports'           => array('title', 'editor', 'excerpt', 'thumbnail', 'custom-fields'),
    'menu_position'      => 5,
    'menu_icon'          => 'dashicons-book-alt',
    'hierarchical'       => false,
  );

  register_post_type('book', $args);
}
add_action('init', 'register_book_post_type');

// Add a shortcode for rendering the books' prices.
function book_price_shortcode($atts) {
  $atts = shortcode_atts([
    'post_id' => get_the_ID(),
  ], $atts, 'book_price');

  $post_id = intval($atts['post_id']);

  if ( ! $post_id ) {
    return '';
  }

  $price = get_post_meta( $post_id, 'book_price', true );
  $e_price = get_post_meta( $post_id, 'ebook_price', true );
  $book_content = $price ? '<p class="book-price">Paperback: ' . esc_html( $price ) . '</p>' : '';
  $ebook_content = $e_price ? '<p class="ebook-price">eBook: ' . esc_html( $e_price ) . '</p>' : '';

  return '<div class="book-price-container">' . $book_content . $ebook_content . '</div>';
}
add_shortcode('book_price', 'book_price_shortcode');

// Send the book post's ID to the shortcode to render accurate prices in the query loop.
add_filter('render_block', function ($block_content, $block) {
  if (
    $block['blockName'] === 'core/shortcode' &&
    isset($block['innerContent'][0]) &&
    strpos($block['innerContent'][0], '[book_price]') !== false
  ) {
    $post_id = get_the_ID();

    // Inject the correct post ID into the shortcode
    $block_content = do_shortcode('[book_price post_id="' . $post_id . '"]');
  }

  return $block_content;
}, 11, 2);

// Remove the "Read More" link from the excerpt block on custom post-type = book.
add_filter( 'render_block', function ( $block_content, $block ) {
  if (
    get_post_type() === 'book' &&
    $block['blockName'] === 'core/post-excerpt' &&
    (strpos( $block_content, 'Read more' ) !== false || strpos( $block_content, 'Read More' ) !== false)
  ) {
    // Remove everything after ellipses (if present), preserving ellipses.
    $block_content = preg_replace(
      '/(\.\.\.|&hellip;).*$/iu',
      '$1',
      $block_content
    );

    // If no ellipses, remove Read more and everything after.
    if (strpos($block_content, '...') === false && strpos($block_content, '&hellip;') === false) {
      $block_content = preg_replace(
        '/\s*Read\s*more.*?(»|›|&raquo;|&gt;|&rsaquo;)?\s*$/iu',
        '',
        $block_content
      );
    }
  }

  return $block_content;
}, 10, 2);

// Exclude the featured book from Query Loop blocks.
add_filter( 'query_loop_block_query_vars', function ( $query_args, $block_context ) {
  if (
    ! empty( $query_args['post_type'] ) &&
    $query_args['post_type'] === 'book' &&
    is_singular( 'book' )
  ) {
    $featured_id = get_the_ID();

    // Ensure that it hasn't already been excluded.
    if ( !in_array( $featured_id, $query_args['post__not_in'] ?? [], true ) ) {
      $query_args['post__not_in'][] = $featured_id;
    }
  }

  return $query_args;
}, 10, 2 );

// Add the book-detail page's link to the image of the query loop.
add_filter( 'render_block', function( $block_content, $block ) {
  if ( $block['blockName'] === 'core/post-featured-image' && is_singular( 'book' ) === true ) {

    // Get the current post ID being rendered.
    $post_id = isset( $block['attrs']['postId'] ) ? $block['attrs']['postId'] : get_the_ID();

    // Fallback if postId is not set.
    if ( !$post_id ) {
      global $post;
      $post_id = $post ? $post->ID : null;
    }

    if ( $post_id ) {
      $permalink = get_permalink( $post_id );

      // Wrap the existing image content with a link.
      $block_content = preg_replace(
        '/(<figure.*?>)(.*?)(<\/figure>)/is',
        '$1<a href="' . esc_url( $permalink ) . '">$2</a>$3',
        $block_content
      );
    }
  }

  return $block_content;
}, 10, 2 );

// // View all actions.
// add_action('all', function ($hook_name = null) {
//   static $seen = [];
//   if (!in_array(current_filter(), $seen, true)) {
//     $seen[] = current_filter();
//     error_log('Hook: ' . current_filter());
//   }
// });
