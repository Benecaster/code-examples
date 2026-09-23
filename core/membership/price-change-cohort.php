<?php
// Exempt founding members from a price change, and react when one takes effect

// Keep anyone who joined before launch on the price they signed up at.
add_filter(
    'benecaster_price_change_cohort',
    function ( array $cohort, array $change ): array {
        return array_values( array_filter(
            $cohort,
            static fn( array $subscription ): bool =>
                ! get_user_meta( (int) $subscription['user_id'], 'my_founding_member', true )
        ) );
    },
    10,
    2
);

// Log each move to a CRM; alert a separate ops channel if Stripe refused any.
add_action(
    'benecaster_price_change_subscriber_applied',
    function ( int $user_id, int $show_id, array $change ): void {
        my_crm_log_price_change( $user_id, $change['item_name'], $change['old_amount_cents'], $change['new_amount_cents'], $change['currency'] );
    },
    10,
    3
);
add_action(
    'benecaster_price_change_applied',
    function ( int $change_id, array $change, array $rows ): void {
        $failed = array_filter( $rows, static fn( array $r ): bool => 'failed' === $r['status'] );
        if ( [] !== $failed ) {
            my_ops_alert( sprintf( '%d subscribers could not be moved on price change #%d', count( $failed ), $change_id ) );
        }
    },
    10,
    3
);
