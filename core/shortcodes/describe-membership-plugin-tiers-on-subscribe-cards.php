<?php
// Describe each tier on a membership-plugin show's subscribe cards

// MemberPress: show each membership's excerpt under its card.
add_action( 'benecaster_subscribe_tier_content', function ( string $slug, int $show_id, string $level_id = '', string $plugin_slug = '' ): void {
    if ( 'memberpress' !== $plugin_slug || '' === $level_id ) {
        return; // A manually managed tier, or another plugin's level.
    }
    $excerpt = get_the_excerpt( (int) $level_id );
    if ( '' !== $excerpt ) {
        echo '<p class="benecaster-subscribe__description">' . esc_html( $excerpt ) . '</p>';
    }
}, 10, 4 );
