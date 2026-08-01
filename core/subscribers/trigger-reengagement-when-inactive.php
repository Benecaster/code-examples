<?php
// Trigger a re-engagement automation when a subscriber goes silent

add_action(
    'benecaster_subscriber_feed_inactive',
    function ( int $user_id, int $show_id, string $tier_slug, int $days_inactive ): void {
        $user = get_userdata( $user_id );
        if ( ! $user ) {
            return;
        }
        my_esp_add_tag( $user->user_email, 'podcast-inactive' );
        my_esp_trigger_sequence( $user->user_email, 're-engagement', [
            'show_id'       => $show_id,
            'days_inactive' => $days_inactive,
        ] );
    },
    10,
    4
);

// Optional: extend the threshold to 60 days for a monthly show.
add_filter(
    'benecaster_subscriber_engagement_threshold',
    function ( int $days, int $show_id ): int {
        return $show_id === MY_MONTHLY_SHOW_ID ? 60 : $days;
    },
    10,
    2
);
