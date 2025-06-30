<?php
if ( !function_exists( 'render_post_carousel_wrapper_block' ) ) {
  function render_post_carousel_wrapper_block( $attributes, $content ) {
    $post_type = $attributes['postType'] ?? 'post';
    $include = $attributes['includeCategories'] ?? [];
    $exclude = $attributes['excludeCategories'] ?? [];

    if ( !is_array( $include ) ) {
      $include = array_map('trim', explode(',', $include));
    }

    if ( !is_array( $exclude ) ) {
      $exclude = array_map('trim', explode(',', $exclude));
    }

    // Modify the inner block content by injecting a filter.
    add_filter( 'ghostkit_post_carousel_query', function ($query_args) use ($post_type, $include, $exclude ) {
      $query_args['post_type'] = $post_type;

      if ( $include ) $query_args['category_name'] = $include;
      if ($exclude) {
        $slugs = array_map( 'trim', explode( ',', $exclude ) );
        $term_ids = get_terms( [
          'taxonomy' => 'category',
          'slug' => $slugs,
          'fields' => 'ids'
        ] );
        if ( !is_wp_error( $term_ids ) ) {
          $query_args['category__not_in'] = $term_ids;
        }
      }

      return $query_args;
    });

    return $content;
  }
}

echo render_post_carousel_wrapper_block( $attributes, $content );