<?php
// // Determine the template being use.
// add_action('template_include', function ($template) {
//   error_log('Template being used: ' . $template);
//   return $template;
// });

// Enqueue parent and child styles
function responsive_child_enqueue_styles() {
  // Enqueue parent theme stylesheet.
  wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');

  // Enqueue main child stylesheet.
  wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/style.css', ['parent-style'], filemtime(get_stylesheet_directory() . '/style.css'));

  // Enqueue modular child styles.
  wp_enqueue_style('child-header-style', get_stylesheet_directory_uri() . '/css/header.css', ['child-style'], filemtime(get_stylesheet_directory() . '/css/header.css'));

  wp_enqueue_style('child-footer-style', get_stylesheet_directory_uri() . '/css/footer.css', ['child-style'], filemtime(get_stylesheet_directory() . '/css/footer.css'));

  wp_enqueue_style('child-products-style', get_stylesheet_directory_uri() . '/css/products.css', ['child-style'], filemtime(get_stylesheet_directory() . '/css/products.css'));

  wp_enqueue_style('child-product-style', get_stylesheet_directory_uri() . '/css/product.css', ['child-style'], filemtime(get_stylesheet_directory() . '/css/product.css'));

  wp_enqueue_style('child-responsive-style', get_stylesheet_directory_uri() . '/css/responsive.css', ['child-style'], filemtime(get_stylesheet_directory() . '/css/responsive.css'));
}
add_action('wp_enqueue_scripts', 'responsive_child_enqueue_styles');

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
    'taxonomies'        => array('category', 'post_tag'), // Add categories and tags support
  );

  register_post_type('book', $args);
}
add_action('init', 'register_book_post_type');

// Register a custom post type for videos.
function register_video_post_type() {
  $labels = array(
    'name'               => 'Videos',
    'singular_name'      => 'Video',
    'menu_name'          => 'Videos',
    'name_admin_bar'     => 'Video',
    'add_new'            => 'Add New',
    'add_new_item'       => 'Add New Video',
    'new_item'           => 'New Video',
    'edit_item'          => 'Edit Video',
    'view_item'          => 'View Video',
    'all_items'          => 'All Videos',
    'search_items'       => 'Search Videos',
    'parent_item_colon'  => 'Parent Videos:',
    'not_found'          => 'No videos found.',
    'not_found_in_trash' => 'No videos found in Trash.',
  );

  $args = array(
    'labels'             => $labels,
    'public'             => true,
    'has_archive'        => true,
    'rewrite'            => array('slug' => 'video'),
    'show_in_rest'       => true, // Enable Gutenberg and REST API
    'supports'           => array('title', 'editor', 'excerpt', 'thumbnail', 'custom-fields'),
    'menu_position'      => 6,
    'menu_icon'          => 'dashicons-video-alt',
    'hierarchical'       => false,
    'taxonomies'        => array('category', 'post_tag'), // Add categories and tags support
  );

  register_post_type('video', $args);
}
add_action('init', 'register_video_post_type');

// Register a custom post type for podcasts.
function register_podcast_post_type() {
  $labels = array(
    'name'               => 'Podcasts',
    'singular_name'      => 'Podcast',
    'menu_name'          => 'Podcasts',
    'name_admin_bar'     => 'Podcast',
    'add_new'            => 'Add New',
    'add_new_item'       => 'Add New Podcast',
    'new_item'           => 'New Podcast',
    'edit_item'          => 'Edit Podcast',
    'view_item'          => 'View Podcast',
    'all_items'          => 'All Podcasts',
    'search_items'       => 'Search Podcasts',
    'parent_item_colon'  => 'Parent Podcasts:',
    'not_found'          => 'No podcasts found.',
    'not_found_in_trash' => 'No podcasts found in Trash.',
  );

  $args = array(
    'labels'             => $labels,
    'public'             => true,
    'has_archive'        => true,
    'rewrite'            => array('slug' => 'video'),
    'show_in_rest'       => true, // Enable Gutenberg and REST API
    'supports'           => array('title', 'editor', 'excerpt', 'thumbnail', 'custom-fields'),
    'menu_position'      => 6,
    'menu_icon'          => 'dashicons-microphone',
    'hierarchical'       => false,
    'taxonomies'        => array('category', 'post_tag'), // Add categories and tags support
  );

  register_post_type('podcast', $args);
}
add_action('init', 'register_podcast_post_type');


// Handler for both [book_buy_url] and [ebook_buy_url] pseudo-shortcodes.
add_filter('render_block', function ($block_content, $block) {
  if (strpos($block_content, '[book_buy_url]') !== false || strpos($block_content, '[ebook_buy_url]') !== false) {
    $post_id = get_the_ID();

    $book_url = esc_url(get_post_meta($post_id, 'book_buy_url', true));
    $ebook_url = esc_url(get_post_meta($post_id, 'ebook_buy_url', true));

    if ($book_url) {
      $block_content = str_replace('href="http://[book_buy_url]"', 'href="' . $book_url . '"', $block_content);
      $block_content = str_replace('href="[book_buy_url]"', 'href="' . $book_url . '"', $block_content);
    } else {
      // Remove the entire .wp-block-button div containing the [book_buy_url] anchor if no URL is present.
      $block_content = preg_replace(
        '/<div class="wp-block-button[^>]*>\s*<a[^>]+href="[^"]*\[book_buy_url\][^"]*"[^>]*>.*?<\/a>\s*<\/div>/is',
        '',
        $block_content
      );
    }

    if ($ebook_url) {
      $block_content = str_replace('href="http://[ebook_buy_url]"', 'href="' . $ebook_url . '"', $block_content);
      $block_content = str_replace('href="[ebook_buy_url]"', 'href="' . $ebook_url . '"', $block_content);
    } else {
      // Remove the entire .wp-block-button div containing the [ebook_buy_url] anchor if no URL is present.
      $block_content = preg_replace(
        '/<div class="wp-block-button[^>]*>\s*<a[^>]+href="[^"]*\[ebook_buy_url\][^"]*"[^>]*>.*?<\/a>\s*<\/div>/is',
        '',
        $block_content
      );
    }
  }

  return $block_content;
}, 12, 2);

// Remove the "Read More" link from the excerpt block on custom post-type = book.
add_filter( 'render_block', function ( $block_content, $block ) {
  if ( $block['blockName'] === 'core/post-excerpt' && (strpos( $block_content, 'Read more' ) !== false || strpos( $block_content, 'Read More' ) !== false )
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

// Exclude the book featured on a book custom post-type from Query Loop blocks.
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
  } elseif (
    ! empty( $query_args['post_type'] ) &&
    $query_args['post_type'] === 'video' &&
    is_singular( 'video' )
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
  if ( 
    $block['blockName'] === 'core/post-featured-image' 
    // && is_singular( 'book' ) === true 
  ) {
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

// Register editor-visible block using block.json metadata.
function register_book_price_block_metadata() {
  register_block_type_from_metadata(
    get_stylesheet_directory() . '/blocks/book-price'
  );
}
add_action('init', 'register_book_price_block_metadata');

// Register the block's assets for the editor.
function register_book_price_block_assets() {
  wp_register_script(
    'book-price-editor-script',
    get_stylesheet_directory_uri() . '/blocks/book-price/index.js',
    [ 'wp-blocks', 'wp-element', 'wp-editor' ],
    filemtime(get_stylesheet_directory() . '/blocks/book-price/index.js')
  );
}
add_action('init', 'register_book_price_block_assets');

// Add a class to the body tag for anything created with page.php.
add_filter( 'body_class', function( $classes ) {

  error_log( 'is post?: ' . ( is_singular( 'post' ) ? 'tis true' : 'tis false' ) );
  
  if ( is_singular('post') || ( is_page() && ( get_page_template_slug() === '' || get_page_template_slug() === 'elementor_header_footer' ) ) ) {
    $classes[] = 'not-custom-page-type';
  }
  return $classes;
} );

// // View all actions.
// add_action('all', function ($hook_name = null) {
//   static $seen = [];
//   if (!in_array(current_filter(), $seen, true)) {
//     $seen[] = current_filter();
//     error_log('Hook: ' . current_filter());
//   }
// });
