<?php
// Mirror Supporter Wall opt-in changes to an external CRM or audit log

add_action( 'benecaster_subscriber_wall_visible', function ( int $user_id, bool $visible ): void {
    my_crm_set_field( $user_id, 'show_on_supporter_wall', $visible );
    my_audit_log( sprintf(
        'user=%d set supporter_wall_visible=%s',
        $user_id,
        $visible ? 'true' : 'false'
    ) );
}, 10, 2 );
