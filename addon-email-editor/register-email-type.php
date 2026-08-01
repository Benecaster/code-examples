<?php
// Register a custom email type with the Email Editor

add_action( 'benecaster_boot', function ( \Benecaster\Container $container ) {
    add_filter( 'benecaster_managed_email_types', function ( array $types ): array {
        $types[] = [
            'type'        => 'my_episode_notification',
            'label'       => 'Episode Notification',
            'description' => 'Sent to subscribers when a new episode becomes available for their tier.',
            'add_on'      => 'my-addon-slug',
        ];
        return $types;
    } );
} );
