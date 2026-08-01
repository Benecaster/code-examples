<?php
// React to subscription events from any bridge

add_action( 'benecaster_subscription_activated', function (
    int    $user_id,
    int    $show_id,
    string $tier_slug,
    string $source       // 'new', 'resubscribe', or 'migration'
) {
    if ( $source === 'new' ) {
        my_crm_tag_contact( get_userdata( $user_id )->user_email, [
            'benecaster_subscriber' => true,
            'tier'                  => $tier_slug,
        ] );
    }
}, 10, 4 );

add_action( 'benecaster_subscription_cancelled', function (
    int $user_id,
    int $show_id
) {
    my_crm_remove_tag( get_userdata( $user_id )->user_email, 'benecaster_subscriber' );
}, 10, 2 );

add_action( 'benecaster_subscription_tier_changed', function (
    int    $user_id,
    int    $show_id,
    string $old_tier_slug,
    string $new_tier_slug
) {
    my_crm_update_field(
        get_userdata( $user_id )->user_email,
        'podcast_tier',
        $new_tier_slug
    );
}, 10, 4 );
