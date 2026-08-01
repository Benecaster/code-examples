<?php
// Hook the resubscribe branch of benecaster_subscription_activated to react to a returning subscriber whose feed URL has just changed

add_action( 'benecaster_subscription_activated', function ( int $user_id, int $show_id, string $tier_slug, string $source ): void {
    if ( 'resubscribe' !== $source ) {
        return;
    }
    // The token row has already been replaced — old feed URL is dead.
    my_addon_invalidate_cached_feed_url( $user_id, $show_id );
    my_addon_tag_user_in_crm( $user_id, 'returning-subscriber' );
}, 10, 4 );
