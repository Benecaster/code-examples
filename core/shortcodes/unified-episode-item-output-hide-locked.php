<?php
// Hide locked episodes from every Benecaster listing surface.
//
// Fires from [benecaster_episodes], [benecaster_latest_episode], and
// [benecaster_related_episodes] — one callback handles all three because
// the filter signature is shared.
//
// Logged-out visitors + logged-in-but-wrong-tier subscribers both see the
// pruned list. Subscribers with access see everything normally.
add_filter( 'benecaster_episode_item_output', function ( string $html, int $episode_id, int $show_id, string $user_tier, bool $is_locked ): string {
    return $is_locked ? '' : $html;
}, 10, 5 );
