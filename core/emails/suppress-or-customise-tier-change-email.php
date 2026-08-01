<?php
// Suppress or customise the built-in tier change email per tier pair

// Suppress the email when the subscriber moves to the free tier (downgrade only).
add_filter( 'benecaster_email_should_send_tier_change', function ( bool $should_send, ?int $user_id, ?int $show_id ): bool {
    // Simple example: suppress all tier change emails for a specific show.
    if ( $show_id === 42 ) {
        return false;
    }
    return $should_send;
}, 10, 3 );

// Add a custom merge tag available in the tier-change template only.
add_filter( 'benecaster_email_merge_tags_tier_change', function ( array $tags, ?int $user_id, ?int $show_id ): array {
    $tags['support_url'] = 'https://example.com/support';
    return $tags;
}, 10, 3 );
