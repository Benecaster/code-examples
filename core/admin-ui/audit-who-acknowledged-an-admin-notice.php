<?php
// Audit who acknowledged an admin notice

add_action( 'benecaster_notice_dismissed', function ( string $notice_id ): void {
    // Only security alerts, e.g. the invalid-token spike alert.
    if ( ! str_starts_with( $notice_id, 'benecaster_invalid_token_alert_' ) ) {
        return;
    }

    $user = wp_get_current_user();
    my_ops_alert( sprintf(
        '%s acknowledged security alert %s at %s',
        $user->exists() ? $user->user_login : 'unknown user',
        $notice_id,
        wp_date( 'Y-m-d H:i T' ) // Site time, from a real UTC timestamp.
    ) );
} );
