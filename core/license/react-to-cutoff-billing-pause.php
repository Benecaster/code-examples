<?php
// React When a Lapsed Licence Stops (and Later Restarts) Subscriber Billing

add_action( 'benecaster_cutoff_billing_pause_complete', 'my_addon_billing_paused', 10, 3 );
add_action( 'benecaster_cutoff_billing_resume_complete', 'my_addon_billing_resumed', 10, 3 );

/**
 * @param int   $paused        Subscriptions successfully paused and tagged.
 * @param array $failures      [ [ 'subscription_id' => string, 'show_id' => int, 'message' => string ], … ]
 * @param array $skipped_shows show_id => 'test_mode' | 'no_keys'
 */
function my_addon_billing_paused( int $paused, array $failures, array $skipped_shows ): void {
    // ⚠ The interesting argument is $failures, not $paused. A failure means
    // that subscriber is STILL BEING CHARGED for a feed returning 403 —
    // the one outcome worth waking somebody up for.
    if ( [] === $failures && [] === $skipped_shows ) {
        return;
    }

    my_addon_alert( sprintf(
        'Benecaster paused %d subscriptions; %d failed, %d shows unreachable.',
        $paused,
        count( $failures ),
        count( $skipped_shows )
    ) );
}

function my_addon_billing_resumed( int $resumed, array $failures, array $skipped_shows ): void {
    // A resume failure is the inverse harm: those subscribers still have
    // access and are NOT being billed for it.
    my_addon_sync_billing_state();
}
