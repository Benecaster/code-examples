<?php
// Push subscription lifecycle events to an external analytics service

// New subscriber joined.
add_action( 'benecaster_token_generated', function (
    int    $token_id,
    int    $user_id,
    int    $show_id,
    string $tier_slug
) {
    my_analytics_track( 'subscriber_joined', [
        'show_id'   => $show_id,
        'tier'      => $tier_slug,
        'timestamp' => time(),
    ] );
}, 10, 4 );

// Subscriber churned.
add_action( 'benecaster_token_revoked', function (
    int $token_id,
    int $user_id,
    int $show_id
) {
    my_analytics_track( 'subscriber_churned', [
        'show_id'   => $show_id,
        'timestamp' => time(),
    ] );
}, 10, 3 );

// Subscriber changed tiers.
add_action( 'benecaster_subscription_tier_changed', function (
    int    $user_id,
    int    $show_id,
    string $old_tier_slug,
    string $new_tier_slug
) {
    my_analytics_track( 'tier_changed', [
        'show_id'   => $show_id,
        'from_tier' => $old_tier_slug,
        'to_tier'   => $new_tier_slug,
        'timestamp' => time(),
    ] );
}, 10, 4 );

function my_analytics_track( string $event, array $properties ): void {
    wp_remote_post( MY_ANALYTICS_ENDPOINT, [
        'body'     => wp_json_encode( array_merge( [ 'event' => $event ], $properties ) ),
        'headers'  => [ 'Content-Type' => 'application/json' ],
        'timeout'  => 3,
        'blocking' => false,
    ] );
}
