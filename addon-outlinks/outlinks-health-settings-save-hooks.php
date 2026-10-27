<?php
// Run your own code when Link Health's schedule or exclusions are saved

add_action( 'benecaster_outlinks_health_exclusions_save_after', function ( array $exclusions, array $previous, int $removed ): void {
    $added = array_diff( $exclusions['domains'], $previous['domains'] );
    if ( [] !== $added ) {
        error_log( sprintf( 'Link Health now skips %s (%d items removed)', implode( ', ', $added ), $removed ) );
    }
}, 10, 3 );
