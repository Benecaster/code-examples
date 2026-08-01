<?php
// Register a custom Member Thanks query type

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

        $count     = (int) ( $args['count'] ?? 5 );
        $tier_slug = $args['tier_slug'] ?? '';

        $sql = $wpdb->prepare(
            "SELECT d.user_id, u.display_name, '' AS tier_slug, '' AS joined_at
             FROM {$wpdb->prefix}benecaster_listener_support_donations d
             JOIN {$wpdb->prefix}users u ON u.ID = d.user_id
             WHERE d.show_id = %d
               AND d.donated_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)
             GROUP BY d.user_id
             ORDER BY SUM(d.amount) DESC
             LIMIT %d",
            $show_id,
            $count > 0 ? $count : PHP_INT_MAX
        );

        return $wpdb->get_results( $sql, ARRAY_A ) ?: [];
    }
}
