<?php
// React to subscription lifecycle events from the built-in membership system

add_action(
    'benecaster_stripe_membership_invoice_payment_failed',
    function ( string $stripe_subscription_id, \Stripe\Event $event ): void {
        // Do not revoke feed access here — core policy is to let Stripe
        // exhaust its retry schedule. Use this hook for diagnostics,
        // creator notifications, CRM updates, etc.
        my_addon_log_payment_retry( $stripe_subscription_id, (int) $event->created );
    },
    10,
    2
);
