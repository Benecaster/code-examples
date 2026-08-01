<?php
// Map an additional user-agent substring to a display label in the dashboard's Top apps breakdown

add_filter( 'benecaster_download_app_patterns', function ( array $patterns ): array {
    // Prepend a custom bucket so it wins ahead of the generic browser fallback.
    return [ 'mycorpbot' => 'My Corp Bot' ] + $patterns;
} );
