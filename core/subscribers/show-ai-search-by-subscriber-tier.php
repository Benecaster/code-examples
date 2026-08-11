<?php
// Show AI Search to subscribers at or above a required tier

add_shortcode( 'my_tiered_search', function ( $atts ): string {
    $atts = shortcode_atts(
        [
            'show_id'       => 0,
            'required_tier' => '',
        ],
        $atts,
        'my_tiered_search'
    );

    $show_id       = (int) $atts['show_id'];
    $required_slug = sanitize_key( (string) $atts['required_tier'] );

    if ( $show_id <= 0 || '' === $required_slug ) {
        return '';
    }

    $ai_shortcode       = sprintf( '[benecaster_ai_search show_id="%d"]', $show_id );
    $fallback_shortcode = sprintf( '[benecaster_search show_id="%d"]', $show_id );

    if ( ! shortcode_exists( 'benecaster_ai_search' ) ) {
        return do_shortcode( $fallback_shortcode );
    }

    $user_tier_slug = benecaster_get_user_tier_for_show( $show_id );
    if ( '' === $user_tier_slug ) {
        return do_shortcode( $fallback_shortcode );
    }

    $repo          = new \Benecaster\Membership\MembershipTierRepository();
    $required_tier = $repo->find_by_slug( $show_id, $required_slug );
    $user_tier     = $repo->find_by_slug( $show_id, $user_tier_slug );

    if ( null === $required_tier || null === $user_tier ) {
        return do_shortcode( $fallback_shortcode );
    }

    if ( (int) $user_tier['tier_order'] >= (int) $required_tier['tier_order'] ) {
        return do_shortcode( $ai_shortcode );
    }

    return do_shortcode( $fallback_shortcode );
} );
