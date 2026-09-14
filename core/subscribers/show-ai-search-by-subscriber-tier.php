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

    // Rank by POSITION in the show's tier list (lowest first), never by
    // the raw tier_order value: tiers created in the Memberships admin
    // all stored tier_order = 0, so comparing values would admit every
    // tier, a free one included.
    $ranked  = ( new \Benecaster\Membership\MembershipTierRepository() )->ranked_slugs( $show_id );
    $user_at = array_search( $user_tier_slug, $ranked, true );
    $need_at = array_search( $required_slug, $ranked, true );

    // If either tier can't be resolved (e.g. tier was deleted), be
    // conservative and fall back to the core search rather than
    // accidentally exposing AI search to someone who shouldn't have it.
    if ( false === $user_at || false === $need_at ) {
        return do_shortcode( $fallback_shortcode );
    }

    if ( $user_at >= $need_at ) {
        return do_shortcode( $ai_shortcode );
    }

    return do_shortcode( $fallback_shortcode );
} );
