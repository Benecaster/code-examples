<?php
// Invalidate locale-keyed caches when the operator changes supported languages

add_action( 'benecaster_supported_locales_updated', function ( array $supported, string $primary, array $prev_supported, string $prev_primary ) {
    $added = array_diff( $supported, $prev_supported );
    foreach ( $added as $locale ) {
        do_action( 'my_addon_locale_added', $locale );
    }
    if ( $primary !== $prev_primary ) {
        delete_transient( 'my_addon_primary_language_strings' );
    }
}, 10, 4 );
