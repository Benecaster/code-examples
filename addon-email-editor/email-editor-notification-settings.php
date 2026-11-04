<?php
// React when a show switches episode notifications on

add_action( 'benecaster_email_editor_after_notification_settings_save', function ( int $show_id, array $settings ): void {
    if ( $settings['enabled'] ) {
        my_crm_note( $show_id, 'Episode emails are on, sent ' . ( 'teaser' === $settings['trigger'] ? 'at publish' : 'as each tier unlocks' ) );
    }
}, 10, 2 );
