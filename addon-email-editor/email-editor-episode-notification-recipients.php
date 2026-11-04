<?php
// Choose who hears about a new episode, and when it counts as new

// Leave staff accounts out of every episode notification.
add_filter( 'benecaster_email_editor_episode_notification_recipients', function ( array $user_ids, int $episode_id, int $show_id, string $trigger_key ): array {
    return array_values( array_filter( $user_ids, fn( int $id ): bool => ! user_can( $id, 'edit_posts' ) ) );
}, 10, 4 );

// Announce episodes up to thirty days old, not seven.
add_filter( 'benecaster_email_editor_episode_notification_is_new', function ( bool $is_new, int $episode_id, int $show_id, int $available_at ): bool {
    $published = (int) strtotime( get_post_field( 'post_date_gmt', $episode_id, 'raw' ) . ' UTC' );
    return max( $available_at, $published ) >= time() - 30 * DAY_IN_SECONDS;
}, 10, 4 );
