<?php
// Clear a retired sale's access before moving an episode

function my_store_clear_retired_product( int $episode_id, string $grant_slug ): bool {
    $get   = rest_do_request( new WP_REST_Request( 'GET', "/benecaster/v1/episodes/{$episode_id}" ) );
    $slugs = array_column( $get->get_data()['unrecognised_availability'] ?? [], 'slug' );
    if ( ! in_array( $grant_slug, $slugs, true ) ) {
        return false; // Not there, or a tier/buy-up slug the route would refuse.
    }

    $route = "/benecaster/v1/episodes/{$episode_id}/unrecognised-availability/" . rawurlencode( $grant_slug );
    return 200 === rest_do_request( new WP_REST_Request( 'DELETE', $route ) )->get_status();
}
