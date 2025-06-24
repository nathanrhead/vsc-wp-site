<?php
/**
 * Template Name: Videos Page
 * Pages Template
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header( 'blogs' );
Responsive\responsive_wrapper_top(); // Before wrapper content hook.

if (
  ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'single' ) ) &&
  ! ( function_exists( 'rea_theme_template_render_at_location' ) && rea_theme_template_render_at_location( 'single' ) ) ) {

  Responsive\responsive_wrapper();

  while ( have_posts() ) :
    the_post();
    the_content();
  endwhile;

  get_template_part( 'loop-nav', get_post_type() );
  ?>
    </main><!-- end of #primary -->
  <?php

  Responsive\responsive_wrapper_close();
}

Responsive\responsive_wrapper_end(); // After wrapper hook.
get_footer();