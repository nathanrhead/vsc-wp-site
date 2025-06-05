<?php
/**
 * Custom layout for Book post type without title
 *
 * @package Responsive WordPress theme
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}
// Get post format.
$format = get_post_format();

Responsive\responsive_entry_before();
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> <?php responsive_schema_markup( 'creativework' ); ?>>
  <?php Responsive\responsive_entry_top(); ?>
  <div class="post-entry">
    <?php
    $elements = responsive_page_single_elements_positioning();

    // Remove the post_title element if it's in the array.
    $elements = array_filter( $elements, function ( $element ) {
      return $element !== 'title';
    });

    foreach ( $elements as $element ) {      
      if ( 'featured_image' === $element && ! post_password_required() ) {
        // get_template_part( 'partials/page/thumbnail' );
      } else {
        get_template_part( 'partials/single/' . $element . '-book' );
      }
    }
    ?>

    <?php
    wp_link_pages(
      array(
        'before' => '<div class="pagination">' . __( 'Pages:', 'responsive' ),
        'after'  => '</div>',
      )
    );
    ?>
  </div><!-- end of .post-entry -->

  <?php
    edit_post_link( __( '<span class="post-edit">Edit</span>', 'responsive' ) );
    Responsive\responsive_entry_bottom();
  ?>
</article><!-- end of #post-<?php the_ID(); ?> -->
<?php
Responsive\responsive_entry_after();
?>