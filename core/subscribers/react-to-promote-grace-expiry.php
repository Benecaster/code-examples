<?php
// Push promote-grace expiry events into a CRM or analytics pipeline

add_action( 'benecaster_promote_grace_expired', function ( int $user_id, int $show_id, string $tier_slug ): void {
    $user = get_userdata( $user_id );
    if ( ! $user ) {
        return;
    }
    my_crm_client()->record_event( 'podcast_subscription_lapsed_post_migration', [
        'email'     => $user->user_email,
        'show_id'   => $show_id,
        'tier_slug' => $tier_slug,
        'channel'   => 'benecaster',
    ] );
}, 10, 3 );
