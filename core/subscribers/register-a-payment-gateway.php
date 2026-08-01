<?php
// Add a new payment processor alongside Stripe

add_action( 'benecaster_boot', function ( \Benecaster\Container $container ): void {
    $container->bind( My\PayPalGateway::class, fn() => new My\PayPalGateway() );
    $container->make( \Benecaster\Payment\PaymentGatewayRegistry::class )
        ->register( $container->make( My\PayPalGateway::class ) );
} );

class PayPalGateway implements \Benecaster\Payment\PodcastPaymentGateway {
    public function get_gateway_slug(): string { return 'benecaster_paypal'; }
    public function is_test_mode(): bool { return (bool) get_option( 'my_paypal_sandbox_mode', false ); }
    // … subscription lifecycle methods …
}
