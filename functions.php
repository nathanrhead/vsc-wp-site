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