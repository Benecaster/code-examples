<?php
// Thank annual switchers, and tell your CRM when a subscriber changes billing period

// Record the intent at once, but grant the perk only when the annual price is actually billed.
add_action(
    'benecaster_subscription_cadence_switch_scheduled',
    function ( int $user_id, int $show_id, int $from_price_id, int $to_price_id, int $switch_at ): void {
        my_crm_note( $user_id, sprintf( 'Switching billing period on %s', wp_date( 'Y-m-d', $switch_at ) ) );
    },
    10,
    5
);
add_action(
    'benecaster_subscription_cadence_switched',
    function ( int $user_id, int $show_id, int $from_price_id, int $to_price_id ): void {
        global $wpdb;
        $unit = $wpdb->get_var( $wpdb->prepare(
            "SELECT interval_unit FROM {$wpdb->prefix}benecaster_membership_prices WHERE id = %d",
            $to_price_id
        ) );
        if ( 'year' === $unit ) {
            my_send_annual_thank_you( $user_id, $show_id );
        }
    },
    10,
    4
);
add_action(
    'benecaster_subscription_cadence_switch_cancelled',
    function ( int $user_id, int $show_id, int $to_price_id, string $reason ): void {
        my_crm_note( $user_id, 'Billing-period switch withdrawn: ' . $reason );
    },
    10,
    4
);
