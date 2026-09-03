<?php
// Tune or bypass the per-IP REST rate limiter

add_filter( 'benecaster_rest_rate_limit_buckets', function ( array $buckets ): array {
    // Most-specific patterns must come before the 'standard' catch-all.
    array_unshift( $buckets, [
        'key'        => 'myaddon_export',
        'limit'      => 5,
        'window'     => 3600,
        'identifier' => 'ip', // or 'user' to partition per logged-in user
        'routes'     => [ '#^/benecaster/v1/myaddon/export$#' ],
        'methods'    => [ 'POST' ],
    ] );
    return $buckets;
} );

add_filter( 'benecaster_rest_rate_limit_skip', function ( bool $skip, \WP_REST_Request $request ): bool {
    $signature = $request->get_header( 'X-MyAddon-Signature' );
    return $signature && hash_equals( my_addon_expected_signature( $request ), $signature );
}, 10, 2 );
