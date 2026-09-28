<?php
// Show an honest finish date before a large send

use Benecaster\Email\Warmup\JobPaces;
use Benecaster\Email\Warmup\SendingPace;
use Benecaster\Email\Warmup\WarmupRamp;

// $container is the Benecaster\Container your benecaster_boot callback received.
function my_addon_describe_send( \Benecaster\Container $container, int $count ): string {
    $ramp       = $container->make( WarmupRamp::class );
    $projection = $ramp->capacity_over_next_days( $count );

    if ( ! $projection['complete'] ) {
        /* translators: %d: number of days */
        $when = sprintf( __( 'This will take more than %d days.', 'my-addon' ), $projection['days'] );
    } else {
        $when = sprintf(
            /* translators: 1: number of days, 2: a date */
            __( 'About %1$d days. The last email should go out on %2$s.', 'my-addon' ),
            $projection['days'],
            $projection['finish_day']
        );
    }

    // Agree with Settings -> Email rather than inventing your own advice.
    if ( ! $ramp->describe()['has_service'] ) {
        $when .= ' ' . __( 'Connecting an email sending service will make this much faster.', 'my-addon' );
    }

    return $when;
}

// Not urgent? Ask for half the daily allowance for this job group.
function my_addon_send_gently( \Benecaster\Container $container, int $related_id ): void {
    $container->make( JobPaces::class )->set(
        $related_id,
        'my_addon_campaign',
        SendingPace::Gentle
    );
}
