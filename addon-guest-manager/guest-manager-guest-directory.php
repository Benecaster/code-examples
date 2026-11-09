<?php
// Switch on, restyle or extend the public guest directory

// Switch the directory on from code, e.g. in a site-setup script.
$request = new WP_REST_Request( 'PATCH', '/benecaster-guest-manager/v1/settings' );
$request->set_body_params( [ 'directory' => true ] );
rest_do_request( $request );

// Put guests with a photo first on each page, keeping A–Z within each group.
add_filter( 'benecaster_guest_manager_guest_directory_data', static function ( array $directory ): array {
    usort( $directory['guests'], static fn( array $a, array $b ): int => ( '' === $a['photo_url'] ) <=> ( '' === $b['photo_url'] ) ?: strcasecmp( $a['name'], $b['name'] ) );
    return $directory;
} );
