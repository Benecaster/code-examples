<?php
// Inject markup or react to Stripe donation events

add_action( 'benecaster_before_donation_form', function ( int $show_id ): void {
    printf( '<p class="legal">%s</p>', esc_html__( 'Donations are non-refundable.', 'my-plugin' ) );
} );

add_action( 'benecaster_after_donation_confirmation', function ( int $show_id, float $amount, string $currency ): void {
    // Amount is 0/USD at server-render time. Use benecaster_donation_received
    // for the real per-donation amount, fired from the Stripe webhook.
    echo '<p><a href="/thanks/">Continue browsing →</a></p>';
}, 10, 3 );

add_action( 'benecaster_donation_received', function ( int $show_id, float $amount, string $currency, array $intent, int $donation_id ): void {
    // Real amount in major units (e.g. 15.00 USD), full PaymentIntent array.
    my_crm_log_donation( $show_id, $amount, $currency, $intent['id'] );
}, 10, 5 );
