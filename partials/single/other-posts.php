<div class="post_other-posts" data-post-id="<?php echo esc_attr( get_the_ID() ); ?>">
  <h2 class="wp-block-heading">Other Articles</h2>
  <div class="wp-block-query is-layout-flow wp-block-query-is-layout-flow">
    <ul class="columns-3 wp-block-post-template is-layout-grid">
      <?php
      // $current_id = get_the_ID();
      $current_id = get_query_var('current_post_id') ?: get_the_ID();
      
      // Retrieve block config from the post.
      $posts_per_page = get_post_meta( $current_id, 'posts_per_page', true );
      $posts_per_page = $posts_per_page ? intval( $posts_per_page ) : 3;
      
      // Retrieve keyword filters from custom fields.
      $keyword_in = get_post_meta( $current_id, 'keyword_include', true );
      $keyword_not_in = get_post_meta( $current_id, 'keyword_exclude', true ); // e.g., archive.
      $keyword_in_array = $keyword_in ? array_map( 'trim', explode( ',', $keyword_in ) ) : [];
      $keyword_not_in_array = $keyword_not_in ? array_map( 'trim', explode( ',', $keyword_not_in ) ) : [];
      $tax_query = [];

      $paged = get_query_var( 'other_paged' ) ?: 1; // Use a custom query var for pagination.
      
      if ( !empty( $keyword_in_array ) ) {
        $tax_query[] = [
          'taxonomy' => 'post_tag',
          'field'    => 'slug',
          'terms'    => $keyword_in_array,
          'operator' => 'IN',
        ];
      }

      if ( !empty( $keyword_not_in_array ) ) {
        $tax_query[] = [
          'taxonomy' => 'post_tag',
          'field'    => 'slug',
          'terms'    => $keyword_not_in_array,
          'operator' => 'NOT IN',
        ];
      }

      if ( count( $tax_query ) > 1 ) {
        $tax_query['relation'] = 'AND';
      }

      $query = new WP_Query([
        'post_type'      => 'post',
        'posts_per_page' => $posts_per_page,
        'post__not_in'   => [ $current_id ],
        'tax_query'      => $tax_query,
        'paged' => get_query_var( 'other_paged' ) ? get_query_var( 'other_paged' ) : 1
      ]);

      if ( $query->have_posts() ) :
        while ( $query->have_posts() ) : $query->the_post(); 
      
        // Strip unwanted injected HTML like the read-more div
        $raw_excerpt = get_the_excerpt();
        $excerpt_cleaned = preg_replace('/<div class="read-more">.*?<\/div>/si', '', $raw_excerpt);

      ?>
          <li <?php post_class(); ?>>
            <div class="wp-block-group">
              <div class="wp-block-group__inner-container is-layout-flow wp-block-group-is-layout-flow">

                <a class="post-link" href="<?php the_permalink(); ?>">
                  <?php if ( has_post_thumbnail() ) : ?>
                    <figure class="wp-block-post-featured-image">
                      <?php the_post_thumbnail( 'medium' ); ?>
                    </figure>
                  <?php endif; ?>
                  <h2 class="wp-block-post-title">
                    <?php the_title(); ?>
                  </h2>
                </a>
                <div class="wp-block-post-excerpt">
                  <p class="wp-block-post-excerpt__excerpt">
                    <?php echo $excerpt_cleaned; ?>
                  </p>
                </div>
              </div>
            </div>
          </li>
        <?php endwhile;
        wp_reset_postdata();
      endif;
      ?>
    </ul>
    <?php
      // Pagination markup using standard WordPress paginate_links logic.
      $big = 999999999; // need an unlikely integer
      echo '<nav class="wp-block-query-pagination is-content-justification-center is-layout-flex wp-block-query-pagination-is-layout-flex" aria-label="Pagination">';
      echo '<div class="wp-block-query-pagination-numbers">';
      echo paginate_links([
        'base'      => add_query_arg( 'other_paged', '%#%' ),
        'format'    => '',
        'total'   => $query->max_num_pages,
        'current' => $paged,
        'type'    => 'plain',
        'prev_text' => '&laquo;',
        'next_text' => '&raquo;',
      ]);
    echo '</div></nav>';
    ?>
  </div>
</div>