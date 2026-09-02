<?php
/**
 * Register a custom Member Thanks query type
 */

// In your add-on's boot class:
add_filter( 'benecaster_member_thanks_query_types', function ( array $types ): array {
    $types['top_donors'] = new MyAddon\TopDonorsQuery();
    return $types;
} );

// Implement BenecasterMemberThanksQueryInterface:
class TopDonorsQuery implements \Benecaster\MemberThanks\BenecasterMemberThanksQueryInterface {

    public function get_label(): string {
        return __( 'Top Donors', 'my-addon' );
    }

    public function get_description(): string {
        return __( 'Members who have donated the most in the past 30 days.', 'my-addon' );
    }

    public function get_results( int $show_id, int $episode_id, array $args ): array {
        global $wpdb;

        $count = (int) ( $args['count'] ?? 5 );

        // Your query answers the part core cannot: WHO. Select IDs only.
        //
        // my_addon_donations is the add-on's own mirror of donation activity,
        // written from benecaster_listener_support_donation_logged. Mirror what
        // you need rather than reading Benecaster's tables directly.
        $user_ids = $wpdb->get_col( $wpdb->prepare(
            "SELECT d.user_id
             FROM {$wpdb->prefix}my_addon_donations d
             WHERE d.show_id = %d
               AND d.donated_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)
             GROUP BY d.user_id
             ORDER BY SUM(d.amount) DESC
             LIMIT %d",
            $show_id,
            $count > 0 ? $count : PHP_INT_MAX
        ) );

        // Core answers the rest: display name, tier, join date — filled the same
        // way the built-in query types fill them.
        return benecaster_get_member_thanks_rows( $show_id, array_map( 'intval', $user_ids ) );
    }
}
