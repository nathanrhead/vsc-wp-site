<?php
/**
 * Header Template for Books page
 *
 * @file           header-videos.php
 * @package        Responsive Child Theme
 * @author         Nathan Cox
 * @copyright      2025 Nathan Cox
 * @license        license.txt
 * @version        Release: 1.0
 * @filesource     wp-content/themes/responsive-child/header-videos.php
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

// Get nav and banner text colors from the Videos page's custom fields.
$videos_page = get_page_by_path( 'videos' );
if ( $videos_page ) {
  $banner_header_text = get_post_meta( $videos_page->ID, 'banner-header-text', true );
  $banner_subheader_text = get_post_meta( $videos_page->ID, 'banner-subheader-text', true );
  if ( ! $banner_header_text ) $banner_header_text = 'Videos';
  if ( ! $banner_subheader_text ) $banner_subheader_text = '';
  $banner_text_color = get_post_meta( $videos_page->ID, 'banner-text-color',  true );
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
    .site-title > a {
      color: <?php echo esc_html( $banner_text_color ); ?>;
      stroke: <?php echo esc_html( $banner_text_color ); ?>;
    }
    
    .site-header {
      padding: 0 1rem;
    }

    #header-image-wrapper {
      position: relative;
      width: 100%;
    }
    #header-image-wrapper #masthead {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      z-index: 10;
      background: transparent;
      color: white;
    }
    .header-bg {
      display: block;
      width: 100%;
      height: auto;
      object-fit: cover;
    }

    /* Clear the background color of the hamburger menu on mobile. */
    .main-navigation .main-navigation-wrapper .menu-toggle,
    .main-navigation.toggled .main-navigation-wrapper .menu-toggle {
      background-color: transparent;
      color: white;
    }

    /* Style the search bar */
    body.page-template-vidoes #page #header-image-wrapper header#masthead .responsive-site-primary-header-wrap .site-header-primary-section-right .search-type-responsive-slide.search-active .search-form .res-search-wrapper {
      position: relative;
      background-color: white;
    }
    body.page-template-vidoes #page #header-image-wrapper header#masthead 
      .responsive-site-primary-header-wrap .site-header-primary-section-right 
      .search-type-responsive-slide.search-active .search-form .res-search-wrapper button.search-submit {
        position: relative; /* take it out of the flow so it can stack */
        z-index: 2; /* make sure it is above background */
    }
    body.page-template-vidoes #page #header-image-wrapper header#masthead .responsive-site-primary-header-wrap .site-header-primary-section-right .search-type-responsive-slide.search-active .search-form .res-search-wrapper button.search-submit svg path {
      fill: black;
    }

    @media all and (width >= 1024px) {
      #header-menu li a,
      #header-menu li a span svg path {
        color: <?php echo esc_html( $banner_text_color ); ?>;
        stroke: <?php echo esc_html( $banner_text_color ); ?>;
      }
    }
  </style>
</head>

<?php
  // Get the featured image of the current page (the Videos page).
  $header_bg_url = has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_ID(), 'full' ) : '';
?>
<body 
  <?php body_class( 'videos-header-page' ); ?> 
  <?php responsive_schema_markup( 'body' ); ?> >
  <?php wp_body_open(); ?>
  <div class="skip-container cf">
    <a class="skip-link screen-reader-text focusable" href="#primary"><?php esc_html_e( '&darr; Skip to Main Content', 'responsive' ); ?></a>
  </div><!-- .skip-container -->

  <div class="site hfeed" id="page">
    <?php if ( $header_bg_url ) : ?>
      <div id="header-image-wrapper">
        <img 
          class="header-bg" 
          src="<?php echo esc_url( $header_bg_url ); ?>" 
          alt="<?php echo esc_attr( get_the_title() ); ?>"
        >
        <div class="header-image-overlay">
          <div class="products-page__header-text-container">
            <h1 <?php echo $banner_text_color ? 'style="color:' . esc_attr( $banner_text_color ) . '"' : ''?>><?php echo esc_html( $banner_header_text ); ?></h1>
            <h4 <?php echo $banner_text_color ? 'style="color:' . esc_attr( $banner_text_color ) . '"' : ''?>><?php echo esc_html( $banner_subheader_text ); ?></h4>
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