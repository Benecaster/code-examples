<?php
// Mirror right-to-erasure/retention purges to external systems

add_action( 'benecaster_after_gdpr_purge', function ( string $source, array $result ): void {
    $user_id = (int) ( $result['user_id'] ?? 0 );
    $email   = (string) ( $result['email'] ?? '' );

    // Resolve email when only the user_id is known (cron path).
    if ( '' === $email && $user_id > 0 ) {
        $user  = get_userdata( $user_id );
        $email = $user instanceof WP_User ? $user->user_email : '';
    }

    if ( '' === $email ) {
        return;
    }

    // Mirror the deletion to your CRM.
    my_crm_delete_contact_by_email( $email );

    // Operator-driven deletions are right-to-erasure requests — log them
    // for your compliance audit trail. Cron sweeps are routine retention.
    if ( 'manual' === $source ) {
        my_compliance_log()->record( 'gdpr_erasure', $email );
    }
}, 10, 2 );
