<?php
// Customize imported episode post data during SSP import

add_filter( 'benecaster_ssp_import_post_data', function ( array $post_data, \WP_Post $ssp_post, int $show_id ): array {
    // Prepend show name to imported episode titles.
    // The title as typed: this is saved into a post, so neither HTML entities nor curly quotes.
    $show_name            = get_post_field( 'post_title', $show_id, 'raw' );
    $post_data['post_title'] = $show_name . ': ' . $post_data['post_title'];
    return $post_data;
}, 10, 3 );
