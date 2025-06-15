<?php
/**
 * Header Template for Books page
 *
 * @file           header-books.php
 * @package        Responsive Child Theme
 * @author         Nathan Cox
 * @copyright      2025 Nathan Cox
 * @license        license.txt
 * @version        Release: 1.0
 * @filesource     wp-content/themes/responsive-child/header-books.php
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Check if Responsive Addons is installed.
 */
if ( ! function_exists( 'check_is_responsive_addons_greater' ) ) {
	function check_is_responsive_addons_greater() {
		if ( is_plugin_active( 'responsive-add-ons/responsive-add-ons.php' ) ) {
			$raddons_version    = get_plugin_data( WP_PLUGIN_DIR . '/responsive-add-ons/responsive-add-ons.php' )['Version'];
			$is_raddons_greater = false;
			if ( version_compare( $raddons_version, '3.0.0', '>=' ) ) {
				$is_raddons_greater = true;
			}
			return $is_raddons_greater;
		}
		return false;
	}
}

// Get nav and banner text colors from the Books page's custom fields.
$books_page = get_page_by_path( 'books' );
if ( $books_page ) {
  $banner_text_color = get_post_meta( $books_page->ID, 'banner-text-color',  true );
  $nav_text_color = get_post_meta( $books_page->ID, 'nav-text-color',  true );
}
?>
<!doctype html>
<html class="no-js" <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="profile" href="http://gmpg.org/xfn/11"/>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>"/>
	<?php wp_head(); ?>
  <style>
    body.page-template-books #page #header-image-wrapper header#masthead .responsive-site-primary-header-wrap .site-header-primary-section-left .site-title a,
    body.page-template-books #page #header-image-wrapper header#masthead .responsive-site-primary-header-wrap .site-header-primary-section-right .main-navigation-wrapper ul li a,
    body.page-template-books #page #header-image-wrapper header#masthead .responsive-site-primary-header-wrap .site-header-primary-section-right .main-navigation-wrapper ul li a svg,
    body.page-template-books #page #header-image-wrapper header#masthead .responsive-site-primary-header-wrap .site-header-primary-section-right .responsive-header-search-link .res-search-icon .responsive-header-search-icon-wrap .responsive-header-search-icon svg {
      color: <?php echo esc_attr( $nav_text_color ? $nav_text_color : '#fff' ); ?>;
      stroke: <?php echo esc_attr( $nav_text_color ? $nav_text_color : '#fff' ); ?>;
    }
    body.page-template-books #page #header-image-wrapper header#masthead .responsive-site-primary-header-wrap .site-header-primary-section-right .search-type-responsive-slide.search-active .search-form .res-search-wrapper {
      position: relative;
      background-color: white;
    }
    body.page-template-books #page #header-image-wrapper header#masthead 
      .responsive-site-primary-header-wrap .site-header-primary-section-right 
      .search-type-responsive-slide.search-active .search-form .res-search-wrapper button.search-submit {
        position: relative; /* take it out of the flow so it can stack */
        z-index: 2; /* make sure it is above background */
    }
    body.page-template-books #page #header-image-wrapper header#masthead .responsive-site-primary-header-wrap .site-header-primary-section-right .search-type-responsive-slide.search-active .search-form .res-search-wrapper button.search-submit svg path {
      fill: black;
    }
    
  </style>
</head>

  <?php
    // Get the featured image of the current page (the Books page).
    $header_bg_url = has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_ID(), 'full' ) : '';
  ?>
<body 
  <?php body_class( 'books-header-page' ); ?> 
  <?php responsive_schema_markup( 'body' ); ?> >
  <?php wp_body_open(); ?>
  <div class="skip-container cf">
    <a class="skip-link screen-reader-text focusable" href="#primary"><?php esc_html_e( '&darr; Skip to Main Content', 'responsive' ); ?></a>
  </div><!-- .skip-container -->

  <div class="site hfeed" id="page">
    <?php if ( $header_bg_url ) : ?>
      <div id="header-image-wrapper">
        <div class="header-image-overlay">
          <img 
            class="header-bg" 
            src="<?php echo esc_url( $header_bg_url ); ?>" 
            alt="<?php echo esc_attr( get_the_title() ); ?>"
          >
          <div class="books-page__header-text-container">
            <h1 <?php echo $banner_text_color ? 'style="color:' . esc_attr( $banner_text_color ) . '"' : ''?>>Books</h1>
            <h4 <?php echo$banner_text_color ? 'style="color:' . esc_attr( $banner_text_color ) . '"' : ''?>>by V S Campbell</h4>
          </div>
        </div>
    <?php endif; ?>
    <?php 
      Responsive\responsive_header_top();

      $responsive_show_header = true;
      if ( class_exists( 'Responsive_Addons_Pro' ) || check_is_responsive_addons_greater() ) {
        if ( ( 1 === get_theme_mod( 'responsive_distraction_free_woocommerce', 0 ) ) && (
          ( is_shop() && 1 === get_theme_mod( 'responsive_disable_shop_header_footer', 0 ) )
          || ( is_product() && 1 === get_theme_mod( 'responsive_disable_single_product_header_footer', 0 ) )
          || ( is_cart() && 1 === get_theme_mod( 'responsive_disable_cart_header_footer', 0 ) )
          || ( is_checkout() && 1 === get_theme_mod( 'responsive_disable_checkout_header_footer', 0 ) )
          || ( is_account_page() && 1 === get_theme_mod( 'responsive_disable_account_header_footer', 0 ) )
          || ( is_product_category() && 1 === get_theme_mod( 'responsive_disable_product_category_header_footer', 0 ) )
          || ( is_product_tag() && 1 === get_theme_mod( 'responsive_disable_product_tag_header_footer', 0 ) )
          ) && 'on' === get_option( 'rpro_woocommerce_enable' )
        ) {
          $responsive_show_header = false;
        }
      }

      // Do not modify or remove the code below.
      if ( ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'header' ) ) && ! ( function_exists( 'rea_theme_template_render_at_location' ) && rea_theme_template_render_at_location( 'header' ) ) && $responsive_show_header ) {

        // Replaces default header with custom header.
        // We want to still call the original responsive_custom_header().
        // You could override this if needed with your own function.
        Responsive\responsive_custom_header();

        if ( ! has_action( 'responsive_custom_header' ) ) {
          /**
           * Responsive before header hook.
           */
          do_action( 'responsive_before_header' );

          /**
           * Responsive header hook.
           */
          Responsive\responsive_header();

          /**
           * Responsive after header hook.
           */
          do_action( 'responsive_after_header' );
        }
      }

	  Responsive\responsive_header_bottom();?>
    <?php if ( $header_bg_url ) ?></div>