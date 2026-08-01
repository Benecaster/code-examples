<?php
// Register an add-on handler on the shared Stripe webhook endpoint

add_filter( 'benecaster_stripe_webhook_handlers', function ( array $handlers ): array {
    $handlers['customer.subscription.created'] = static function ( \Stripe\Event $event ): void {
        $sub = $event->data->object;
        my_addon_record_subscription( $sub->id, $sub->customer, $sub->status );
    };
    return $handlers;
} );
