<?php
// // Determine the template being use.
// add_action('template_include', function ($template) {
//   echo 'Template being used: ' . $template;
//   return $template;
// });

// Enqueue parent and child styles.
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

  wp_enqueue_style('child-post-style', get_stylesheet_directory_uri() . '/css/post.css', ['child-style'], filemtime(get_stylesheet_directory() . '/css/post.css'));

  wp_enqueue_style('child-responsive-style', get_stylesheet_directory_uri() . '/css/responsive.css', ['child-style'], filemtime(get_stylesheet_directory() . '/css/responsive.css'));

  wp_enqueue_style('child-homepage-style', get_stylesheet_directory_uri() . '/css/homepage.css', ['child-style'], filemtime(get_stylesheet_directory() . '/css/homepage.css'));

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

// Enqueue custom post-carousel assests.
function enqueue_custom_post_carousel_editor_assets() {
  wp_register_script(
    'custom-post-carousel-wrapper-editor',
    get_stylesheet_directory_uri() . '/blocks/custom-post-carousel-wrapper/index.js',
    [ 'wp-blocks', 'wp-element', 'wp-editor', 'wp-components', 'wp-block-editor' ],
    null,
    true
  );
}
add_action( 'enqueue_block_editor_assets', 'enqueue_custom_post_carousel_editor_assets' );

// Register a custom post-type for books.
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
    'supports'           => array('title', 'editor', 'excerpt', 'thumbnail', 'custom-fields', 'comments'),
    'menu_position'      => 5,
    'menu_icon'          => 'dashicons-book-alt',
    'hierarchical'       => false,
    'taxonomies'        => array('category', 'post_tag'), // Add categories and tags support
  );

  register_post_type('book', $args);
}
add_action('init', 'register_book_post_type');

// Register a custom post-type for videos.
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
    'supports'           => array('title', 'editor', 'excerpt', 'thumbnail', 'custom-fields', 'comments'),
    'menu_position'      => 6,
    'menu_icon'          => 'dashicons-video-alt',
    'hierarchical'       => false,
    'taxonomies'        => array('category', 'post_tag'), // Add categories and tags support
  );

  register_post_type('video', $args);
}
add_action('init', 'register_video_post_type');

// Register a custom post-type for podcasts.
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
    'rewrite'            => array('slug' => 'podcast'),
    'show_in_rest'       => true, // Enable Gutenberg and REST API
    'supports'           => array('title', 'editor', 'excerpt', 'thumbnail', 'custom-fields', 'comments'),
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
  if ( $block_content && ( strpos( $block_content, '[book_buy_url]' ) !== false || strpos( $block_content, '[ebook_buy_url]' ) !== false ) ) {
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

// Remove the "Read More" link from the excerpt block.
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

// Exclude the post featured on a custom post-type from Query Loop blocks. 
add_filter( 'query_loop_block_query_vars', function ( $query_args, $block_context ) {
  if ( is_singular() ) {
    $featured_id = get_the_ID();

    // Ensure that it hasn't already been excluded.
    if ( !in_array( $featured_id, $query_args['post__not_in'] ?? [], true ) ) {
      $query_args['post__not_in'][] = $featured_id;
    }
  }

  return $query_args;
}, 10, 2 );

// Add the post's link to the featured image and post title in the query loop.
add_filter( 'render_block', function( $block_content, $block ) {  
  if ( 
    $block['blockName'] === 'core/post-featured-image' 
  ) {
    // Get the current post ID being rendered.
    $post_id = isset( $block['attrs']['postId'] ) ? $block['attrs']['postId'] : get_the_ID();

    // Fallback if postId is not set.
    if ( !$post_id ) {
      global $post;
      $post_id = $post ? $post->ID : null;
    }

    if ( $post_id ) {
      // Skip wrapping if we're inside a Query Loop on a single post view of that same post.
      if ( is_singular() && get_queried_object_id() === $post_id ) {
        return $block_content;
      } else {
        $permalink = get_permalink( $post_id );
  
        // Wrap the existing image content with a link.
        $block_content = preg_replace(
          '/(<figure.*?>)(.*?)(<\/figure>)/is',
          '$1<a href="' . esc_url( $permalink ) . '">$2</a>$3',
          $block_content
        );
      }
    }
  }
  // Also wrap the post title in a link in the Query Loop, but not on single post view.
  elseif ( $block['blockName'] === 'core/post-title' ) {
    $post_id = isset( $block['attrs']['postId'] ) ? $block['attrs']['postId'] : get_the_ID();

    if ( !$post_id ) {
      global $post;
      $post_id = $post ? $post->ID : null;
    }

    if ( $post_id ) {
      // Avoid wrapping if this is the single post view of the same post.
      if ( is_singular() && get_queried_object_id() === $post_id ) {
        return $block_content;
      } else {
        $permalink = get_permalink( $post_id );
        $block_content = preg_replace(
          '/(<h[1-6][^>]*class="[^"]*wp-block-post-title[^"]*"[^>]*>)(.*?)(<\/h[1-6]>)/is',
          '$1<a href="' . esc_url( $permalink ) . '">$2</a>$3',
          $block_content
        );
      }
    }
  }

  return $block_content;
}, 10, 2 );

// Register the custom post-carousel-wrapper dynamic block via block.json.
function responsive_child_register_carousel_wrapper_block() {
    register_block_type( get_stylesheet_directory() . '/blocks/custom-post-carousel-wrapper/block.json' );
}
add_action( 'init', 'responsive_child_register_carousel_wrapper_block' );

// Patch the custom config of the wrapper into Responsive's Post Carousel block.
function patch_responsive_carousel_block( $block_content, $block ) {
  if ( $block['blockName'] !== 'custom/post-carousel-wrapper' ) {
    return $block_content;
  }

  if ( empty( $block['innerBlocks'] ) ) {
    return $block_content;
  }

  $inner_block = $block['innerBlocks'][0];

  if ( $inner_block['blockName'] !== 'responsive-block-editor-addons/post-carousel' ) {
    return $block_content;
  }

  // Pull wrapper attributes
  $post_type = $block['attrs']['postType'] ?? 'post';
  $include_categories = $block['attrs']['includeCategories'] ?? '';

  // Coerce category values into arrays of term IDs
  $include_array = array_filter(array_map(function($slug) {
    $term = get_term_by('slug', trim($slug), 'category');
    return $term ? $term->term_id : null;
  }, explode(',', $include_categories)));

  // Inject into inner block's attributes
  $inner_block['attrs']['postType'] = $post_type;

  if ( !empty( $include_array ) ) {
    $inner_block['attrs']['categories'] = $include_array;
  }

  // Let Responsive handle its own query using updated attributes
  return render_block( $inner_block );
}
add_filter( 'render_block', 'patch_responsive_carousel_block', 10, 2 );

// Patch Responsive's post carousel, replacing the default query and markup with a custom query and markup.
add_action('init', function () {
  $block_type = WP_Block_Type_Registry::get_instance()->get_registered('responsive-block-editor-addons/post-carousel');

  if ($block_type && isset($block_type->render_callback)) {
    $original_callback = $block_type->render_callback;

    // Override the render_callback with our own.
    $block_type->render_callback = function ($attributes, $content) use ($original_callback) {
      $post_type = [];
      if (!empty($attributes['postType'])) {
        if (is_array($attributes['postType'])) {
          $post_type = $attributes['postType'];
        } else {
          $post_type = array_map('trim', explode(',', $attributes['postType']));
        }
      }      
      
      $raw_categories = $attributes['categories'] ?? [];
      $categories = is_array($raw_categories) ? $raw_categories : array_map('trim', explode(',', (string) $raw_categories));

      $args = [
        'post_type'      => $post_type,
        'posts_per_page' => $attributes['postsToShow'] ?? 6,
        'post_status'    => 'publish',
        'order'          => $attributes['order'] ?? 'desc',
        'orderby'        => $attributes['orderBy'] ?? 'date',
        'offset'         => $attributes['offset'] ?? 0,
      ];

      if (!empty($categories)) {
        $args['tax_query'] = [[
          'taxonomy' => 'category',
          'field'    => 'term_id',
          'terms'    => $categories,
        ]];
      }

      $query = new WP_Query($args);

      ob_start();
      ?>
      <section class="responsive-block-editor-addons-block-post-carousel block-<?php echo esc_attr($attributes['block_id'] ?? ''); ?> responsive-post-grid responsive-post__image-position-top featuredpost align<?php echo esc_attr($attributes['align'] ?? 'center'); ?>" data-carouselid="<?php echo esc_attr($attributes['block_id'] ?? ''); ?>">
        <div class="responsive-post-slick-carousel-<?php echo esc_attr($attributes['block_id'] ?? ''); ?> responsive-post_carousel-equal-height-<?php echo esc_attr($attributes['equalHeight'] ?? 1); ?> is-carousel columns-<?php echo esc_attr($attributes['columns'] ?? 3); ?>"
          data-slick='<?php
            $slick = [
              "slidesToShow" => $attributes['columns'] ?? 3,
              "slidesToScroll" => 1,
              "autoplaySpeed" => $attributes['autoplaySpeed'] ?? 2000,
              "autoplay" => !empty($attributes['autoplay']),
              "infinite" => !empty($attributes['infiniteLoop']),
              "pauseOnHover" => !empty($attributes['pauseOnHover']),
              "speed" => $attributes['transitionSpeed'] ?? 500,
              "arrows" => (isset($attributes['arrowDots']) && (strpos($attributes['arrowDots'], 'arrows') !== false)),
              "dots" => (isset($attributes['arrowDots']) && (strpos($attributes['arrowDots'], 'dots') !== false)),
              "rtl" => is_rtl(),
              "responsive" => [
                [
                  "breakpoint" => 976,
                  "settings" => [
                    "slidesToShow" => $attributes['columnsTablet'] ?? 1,
                    "slidesToScroll" => 1,
                  ],
                ],
                [
                  "breakpoint" => 767,
                  "settings" => [
                    "slidesToShow" => $attributes['columnsMobile'] ?? 1,
                    "slidesToScroll" => 1,
                  ],
                ],
              ],
            ];
            echo esc_attr(json_encode($slick));
          ?>'>
          <?php while ($query->have_posts()) : $query->the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('responsive-block-editor-addons-post-carousel-item'); ?>>
              <div class="responsive-block-editor-addons-post-carousel-inner">
                <?php if (empty($attributes['displayPostImage']) || $attributes['displayPostImage']): ?>
                <div class="responsive-block-editor-addons-block-post-carousel-image-<?php echo esc_attr($attributes['imagePosition'] ?? 'top'); ?>">
                  <a href="<?php the_permalink(); ?>" rel="bookmark" aria-hidden="true" tabindex="-1">
                    <?php the_post_thumbnail($attributes['imageSize'] ?? 'full'); ?>
                  </a>
                </div>
                <?php endif; ?>
                <div class="responsive-block-editor-addons-block-post-carousel-text-wrap">
                  <header class="responsive-block-editor-addons-block-post-carousel-header">
                    <?php if (empty($attributes['displayPostTitle']) || $attributes['displayPostTitle']): ?>
                      <a href="<?php the_permalink(); ?>" rel="bookmark" aria-hidden="true" tabindex="-1">
                        <<?php echo esc_html($attributes['postTitleTag'] ?? 'h3'); ?> class="carousel-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></<?php echo esc_html($attributes['postTitleTag'] ?? 'h3'); ?>>
                      </a>
                    <?php endif; ?>
                  </header>
                  <?php if (empty($attributes['displayPostExcerpt']) || $attributes['displayPostExcerpt']): ?>
                  <div class="responsive-block-editor-addons-block-post-carousel-excerpt">
                    <p class="wp-block-post-excerpt__excerpt">
                      <?php
                        $excerpt = get_the_excerpt();
                        $excerpt = preg_replace('/<div class="read-more">.*?<\/div>/is', '', $excerpt);
                        $excerpt = preg_replace('/<!–.*?–>/u', '', $excerpt);
                        if (!empty($attributes['excerptLength']) && is_numeric($attributes['excerptLength'])) {
                          $words = explode(' ', wp_strip_all_tags($excerpt));
                          if (count($words) > $attributes['excerptLength']) {
                            $excerpt = implode(' ', array_slice($words, 0, $attributes['excerptLength'])) . '&hellip;';
                          }
                        }
                        echo $excerpt;
                      ?>
                    </p>
                  </div>
                  <?php endif; ?>
                  <?php if (!empty($attributes['displayPostDate'])): ?>
                  <div class="responsive-block-editor-addons-block-post-carousel-date">
                    <?php echo get_the_date(); ?>
                  </div>
                  <?php endif; ?>
                  <?php if (!empty($attributes['displayPostAuthor'])): ?>
                  <div class="responsive-block-editor-addons-block-post-carousel-author">
                    <?php esc_html_e('By', 'responsive'); ?> <?php the_author(); ?>
                  </div>
                  <?php endif; ?>
                  <?php if (!empty($attributes['displayPostTaxonomy'])): ?>
                  <div class="responsive-block-editor-addons-block-post-carousel-taxonomy">
                    <?php the_category(', '); ?>
                  </div>
                  <?php endif; ?>
                  <?php if (!empty($attributes['displayPostComment'])): ?>
                  <div class="responsive-block-editor-addons-block-post-carousel-comments">
                    <?php comments_number(); ?>
                  </div>
                  <?php endif; ?>
                  <?php if (!empty($attributes['displayPostLink'])): ?>
                  <div class="responsive-block-editor-addons-block-post-carousel-read-more">
                    <a href="<?php the_permalink(); ?>" class="carousel-read-more">
                      <?php echo esc_html($attributes['readMoreText'] ?? 'Continue Reading'); ?>
                    </a>
                  </div>
                  <?php endif; ?>
                </div>
              </div>
            </article>
          <?php endwhile; wp_reset_postdata(); ?>
        </div>
      </section>
      <?php
      return ob_get_clean();
    };
  }
});

// Register editor-visible book-price block using block.json metadata.
function register_book_price_block_metadata() {
  register_block_type_from_metadata(
    get_stylesheet_directory() . '/blocks/book-price'
  );
}
add_action('init', 'register_book_price_block_metadata');

// Register the book-price block's assets for the editor.
function register_book_price_block_assets() {
  wp_register_script(
    'book-price-editor-script',
    get_stylesheet_directory_uri() . '/blocks/book-price/index.js',
    [ 'wp-blocks', 'wp-element', 'wp-editor' ],
    filemtime(get_stylesheet_directory() . '/blocks/book-price/index.js')
  );
}
add_action('init', 'register_book_price_block_assets');

// Register editor-visible link-to-content block using block.json metadata.
function register_link_to_content_block_metadata() {
  register_block_type_from_metadata( get_stylesheet_directory() . '/blocks/link-to-content' );
}
add_action('init', 'register_link_to_content_block_metadata' );

// Register the link-to-content block's assets for the editor.
function register_link_to_content_block_assets() {
  wp_register_script( 'link-to-content-editor-script', get_stylesheet_directory_uri() . '/blocks/link-to-content/index.js', ['wp-blocks', 'wp-element', 'wp-editor'], filemtime( get_stylesheet_directory() . '/blocks/link-to-content/index.js' ) );
}
add_action('init', 'register_link_to_content_block_assets' );

// Add a class to the body tag for anything created with page.php.
add_filter( 'body_class', function( $classes ) {  
  if ( is_singular('post') || ( is_page() && ( get_page_template_slug() === '' || get_page_template_slug() === 'elementor_header_footer' ) ) ) {
    $classes[] = 'not-custom-page-type';
  }
  return $classes;
} );

// Split blog-post content into two parts, the first to be rendered on page load, the second on user click.
function truncate_html( $html, $limit = 3000 ) {
  if (mb_strlen(strip_tags($html)) <= $limit) {
    return [
      'truncated' => $html,
      'remainder' => ''
    ];
  }

  libxml_use_internal_errors(true);
  $doc = new DOMDocument();
  $doc->loadHTML('<?xml encoding="UTF-8"><div>' . $html . '</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
  libxml_clear_errors();

  $wrapper = $doc->documentElement;
  $truncated = '';
  $remainder = '';
  $count = 0;
  $limit_reached = false;

  foreach ($wrapper->childNodes as $node) {
    $node_html = $doc->saveHTML($node);
    $node_text = strip_tags($node_html);
    $len = mb_strlen($node_text);

    if (!$limit_reached && ($count + $len) <= $limit) {
      $truncated .= $node_html;
      $count += $len;
    } else {
      $limit_reached = true;
      $remainder .= $node_html;
    }
  }

  return [
    'truncated' => $truncated,
    'remainder' => $remainder ? '<div style="margin-top: 1.5em;">' . $remainder . '</div>' : ''
  ];
}

// Register a custom query variable for paginated other-articles posts.
function vsc_register_other_paged_query_var( $vars ) {
  $vars[] = 'other_paged';
  return $vars;
}
add_filter( 'query_vars', 'vsc_register_other_paged_query_var' );

function vsc_enqueue_other_posts_ajax_script() {
  wp_enqueue_script(
    'vsc-other-posts-ajax',
    get_stylesheet_directory_uri() . '/js/other-posts-ajax.js',
    [ 'jquery' ],
    null,
    true
  );

  wp_localize_script( 'vsc-other-posts-ajax', 'vscOtherPosts', [
    'ajax_url' => admin_url( 'admin-ajax.php' ),
    'nonce'    => wp_create_nonce( 'vsc_other_posts_nonce' ),
  ]);
}
add_action( 'wp_enqueue_scripts', 'vsc_enqueue_other_posts_ajax_script' );

function vsc_handle_other_posts_ajax() {
  check_ajax_referer( 'vsc_other_posts_nonce', 'nonce' );

  $paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;  
  $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;

  if ( ! $post_id ) wp_send_json_error();

  ob_start();
  set_query_var( 'other_paged', $paged );
  set_query_var( 'current_post_id', $post_id );
  get_template_part( 'partials/single/other-posts' );
  $html = ob_get_clean();

  wp_send_json_success([ 'html' => $html ]);
}
add_action( 'wp_ajax_vsc_load_other_posts', 'vsc_handle_other_posts_ajax' );
add_action( 'wp_ajax_nopriv_vsc_load_other_posts', 'vsc_handle_other_posts_ajax' );

// // View all actions.
// add_action('all', function ($hook_name = null) {
//   static $seen = [];
//   if (!in_array(current_filter(), $seen, true)) {
//     $seen[] = current_filter();
//     error_log('Hook: ' . current_filter());
//   }
// });

// // Get the theme's style settings.
// echo '<pre>';
// print_r( get_theme_mods() );
// echo '</pre>';

// add_action('init', function () {
//   $block = WP_Block_Type_Registry::get_instance()->get_registered('responsive-block-editor-addons/post-carousel');
//   if ($block) {
//     error_log('Registered Responsive Post Carousel Block: ' . print_r($block, true));
//   } else {
//     error_log('Responsive Post Carousel block not found.');
//   }
// });
