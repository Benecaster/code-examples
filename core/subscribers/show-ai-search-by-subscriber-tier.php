<?php
// Show AI Search to subscribers at or above a required tier, fall back to core search

/**
 * Tier-gated search shortcode.
 *
 * Usage: [my_tiered_search show_id="123" required_tier="growth"]
 *
 * - Subscribers whose active tier for show 123 has a tier_order >= growth's
 *   tier_order will see [benecaster_ai_search show_id="123"].
 * - Everyone else (lower tiers, no token, logged-out) will see
 *   [benecaster_search show_id="123"].
 *
 * Requires the AI Search add-on to be active for the AI branch to render;
 * when the add-on is inactive, [benecaster_ai_search] is unregistered and
 * WordPress returns the raw shortcode text — the recipe below detects that
 * case and falls back to the core search.
 */
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

    // AI Search add-on isn't active — the tag is unregistered.
    // Always fall through to the core search in that case.
    if ( ! shortcode_exists( 'benecaster_ai_search' ) ) {
        return do_shortcode( $fallback_shortcode );
    }

    // Preview-as-Tier and logged-out users are both handled by
    // benecaster_get_user_tier_for_show(): admins in preview mode return
    // the previewed tier via the benecaster_user_tier_for_show filter;
    // logged-out users return ''.
    $user_tier_slug = benecaster_get_user_tier_for_show( $show_id );
    if ( '' === $user_tier_slug ) {
        return do_shortcode( $fallback_shortcode );
    }

    $repo          = new \Benecaster\Membership\MembershipTierRepository();
    $required_tier = $repo->find_by_slug( $show_id, $required_slug );
    $user_tier     = $repo->find_by_slug( $show_id, $user_tier_slug );

    // If either tier can't be resolved (e.g. tier was deleted), be
    // conservative and fall back to the core search rather than
    // accidentally exposing AI search to someone who shouldn't have it.
    if ( null === $required_tier || null === $user_tier ) {
        return do_shortcode( $fallback_shortcode );
    }

    // tier_order is displayed ASC (cheapest first). Higher tier_order =
    // ranked higher, so "at or above" is >=.
    if ( (int) $user_tier['tier_order'] >= (int) $required_tier['tier_order'] ) {
        return do_shortcode( $ai_shortcode );
    }

    return do_shortcode( $fallback_shortcode );
} );
