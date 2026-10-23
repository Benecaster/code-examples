<?php
// Treat synced members as existing members in an integration

add_action( 'benecaster_subscription_activated', function ( int $user_id, int $show_id, string $tier_slug ): void {
    my_crm_upsert_member( $user_id, $show_id, $tier_slug, [ 'start_welcome_sequence' => true ] );
}, 10, 3 );

add_action( 'benecaster_subscription_synced', function ( int $user_id, int $show_id, string $tier_slug, ?string $started_at ): void {
    my_crm_upsert_member( $user_id, $show_id, $tier_slug, [
        'start_welcome_sequence' => false,
        'member_since'           => $started_at, // UTC; null when the plugin had no usable date
    ] );
}, 10, 4 );
