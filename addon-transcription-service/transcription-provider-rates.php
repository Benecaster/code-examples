<?php
// Use your own rate in the cost estimate

add_filter( 'benecaster_transcription_provider_rates', function ( array $rates ): array {
    $rates['deepgram'] = 0.0030; // A negotiated rate.

    // A custom provider: its own slug for the bulk estimate, `custom` for the monthly line.
    $rates['my-provider'] = 0.0040;
    $rates['custom']      = 0.0040;

    return $rates;
} );
