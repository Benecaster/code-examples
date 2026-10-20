<?php
// Retag a subscriber in your email platform whenever their tier changes — whatever handles billing

add_action( 'benecaster_subscription_tier_moved', function ( int $user_id, int $show_id, string $old_tier, string $new_tier ): void {
    $user = get_userdata( $user_id );
    if ( ! $user ) {
        return;
    }

    // 1 = upgrade, -1 = downgrade, 0 = same tier, null = cannot rank (e.g. a tier deleted since).
    $cmp = benecaster_compare_tiers( $show_id, $new_tier, $old_tier );

    my_esp_remove_tag( $user->user_email, 'tier-' . $old_tier );
    my_esp_add_tag( $user->user_email, 'tier-' . $new_tier );
    if ( null !== $cmp && 0 !== $cmp ) {
        my_esp_add_tag( $user->user_email, $cmp > 0 ? 'upgraded' : 'downgraded' );
    }
}, 10, 4 );
