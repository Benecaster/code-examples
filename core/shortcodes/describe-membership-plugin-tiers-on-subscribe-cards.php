<?php
// Describe each tier on a membership-plugin show's subscribe cards

// MemberPress: show each membership's excerpt under its card.
add_action( 'benecaster_subscribe_tier_content', function ( string $slug, int $show_id ): void {
    global $wpdb;
    $level_ids = $wpdb->get_col( $wpdb->prepare(
        "SELECT external_tier_id FROM {$wpdb->prefix}benecaster_tier_map
         WHERE show_id = %d AND internal_tier_slug = %s AND plugin_slug = 'memberpress'",
        $show_id,
        $slug
    ) );
    $level_id = (int) ( $level_ids[0] ?? 0 );
    $excerpt  = $level_id ? get_the_excerpt( $level_id ) : '';
    if ( '' !== $excerpt ) {
        echo '<p class="benecaster-subscribe__description">' . esc_html( $excerpt ) . '</p>';
    }
}, 10, 2 );
