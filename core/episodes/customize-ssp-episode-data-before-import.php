<?php
// Customize imported episode post data during SSP/PowerPress import

add_filter( 'benecaster_ssp_import_post_data', function ( array $post_data, \WP_Post $ssp_post, int $show_id ): array {
    // Prepend show name to imported episode titles.
    $show_name            = get_the_title( $show_id );
    $post_data['post_title'] = $show_name . ': ' . $post_data['post_title'];
    return $post_data;
}, 10, 3 );
