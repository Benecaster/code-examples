<?php
// Add a new payment processor alongside Stripe

add_filter( 'benecaster_payment_gateways', function ( array $gateways ): array {
    $gateways['benecaster_paypal'] = new PayPalGateway();

    return $gateways;
} );

class PayPalGateway implements \Benecaster\Payment\PodcastPaymentGateway {
    public function get_gateway_slug(): string { return 'benecaster_paypal'; }
    public function is_test_mode(): bool { return (bool) get_option( 'my_paypal_sandbox_mode', false ); }
    // … subscription lifecycle methods …
}
