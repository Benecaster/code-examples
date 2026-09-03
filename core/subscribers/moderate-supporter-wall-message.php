<?php
// Moderate or audit-log every Supporter Wall message

add_action( 'benecaster_subscriber_wall_message', function ( int $user_id, string $message ): void {
    if ( '' === $message ) {
        return; // Nothing to moderate on a clear.
    }
    if ( my_profanity_filter_flags( $message ) ) {
        // Blank the meta immediately, then notify the podcaster.
        // NOTE: calling update_user_meta directly here does NOT re-fire benecaster_subscriber_wall_message.
        // The action only fires when the write goes through SupporterWallManager::set_subscriber_message().
        // This is intentional — it prevents infinite loops in moderation hooks.
        update_user_meta( $user_id, '_benecaster_subscriber_wall_message', '' );
        // Plain wp_mail() is deliberate: operator alert to the site's own admin address.
        // Use benecaster_mail() for anything a podcaster or subscriber reads.
        wp_mail(
            get_option( 'admin_email' ),
            'Flagged Supporter Wall message',
            sprintf( 'User %d wrote a message that tripped the profanity filter and was auto-cleared.', $user_id )
        );
    }
}, 10, 2 );
