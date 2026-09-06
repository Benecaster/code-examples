<?php
// Keep a CRM in step with manual grace-period decisions

add_action( 'benecaster_promote_grace_cleared', function ( array $promotion, int $user_id ): void {
    my_crm_client()->close_task( 'podcast_migration_reauth', [
        'user_id'   => $user_id,
        'show_id'   => $promotion['show_id'],
        'tier_slug' => $promotion['tier_slug'],
        // Still readable here - the row is the pre-clear snapshot.
        'moved_to'  => $promotion['promoted_to_bridge'],
    ] );
}, 10, 2 );

add_action( 'benecaster_promote_grace_extended', function ( array $promotion, int $user_id, int $new_expiry_ts ): void {
    my_crm_client()->reschedule_reminder( $user_id, $new_expiry_ts );
}, 10, 3 );
