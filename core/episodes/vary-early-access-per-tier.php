<?php
// Vary early access per tier when availability is set

add_filter( 'benecaster_availability_datetimes', function ( array $tier_datetimes, int $episode_id, int $show_id ): array {
    // Founding members get everything three days before everyone else.
    if ( isset( $tier_datetimes['gold'] ) ) {
        $tier_datetimes['founding'] = gmdate(
            'Y-m-d H:i:s',
            strtotime( $tier_datetimes['gold'] . ' -3 days' )
        );
    }

    return $tier_datetimes;
}, 10, 3 );
