<?php
// Ask for marketing consent on Benecaster's own forms, and sync only confirmed yeses

// 1. Ask — only on shows where your add-on is switched on.
add_filter( 'benecaster_marketing_consent_label', function ( ?string $label, int $show_id ): ?string {
    if ( ! benecaster_addon_is_active( 'my-addon', $show_id ) ) {
        return $label;
    }
    return __( 'Email me about new episodes and offers from this show.', 'my-addon' );
}, 10, 2 );

// 2. React — queue the API call; this runs inside a form post or a Stripe webhook.
add_action( 'benecaster_marketing_consent_changed', function ( int $user_id, int $show_id, bool $granted, string $source, bool $verified ): void {
    if ( ! benecaster_addon_is_active( 'my-addon', $show_id ) ) {
        return;
    }
    if ( $granted && $verified ) {
        as_enqueue_async_action( 'my_addon_subscribe', [ $user_id, $show_id ] );
    } elseif ( ! $granted ) {
        as_enqueue_async_action( 'my_addon_unsubscribe', [ $user_id, $show_id ] );
    }
    // granted && ! verified: wait — the address owner has not confirmed yet.
}, 10, 5 );

// 3. Decide for a listener Benecaster never asked (joined via a membership plugin, before you asked, or added by an admin).
function my_addon_may_email( int $user_id, int $show_id ): bool {
    $consent = benecaster_get_marketing_consent( $user_id, $show_id );
    if ( null === $consent ) {
        return 'opt_out' === get_option( "my_addon_opt_in_mode_{$show_id}" ); // your default, never Benecaster's
    }
    return $consent['granted'] && $consent['verified'];
}
