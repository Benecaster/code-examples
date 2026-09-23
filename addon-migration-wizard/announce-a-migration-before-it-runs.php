<?php
// Announce a migration before it runs

// Tell the site owner the moment a migration opens, so nobody is surprised
// by a burst of new accounts on the Subscribers screen.
add_action(
    'benecaster_migration_import_started',
    static function ( int $show_id, string $platform, int $batch_id ): void {
        $show = get_the_title( $show_id );

        wp_mail(
            get_option( 'admin_email' ),
            sprintf( 'Migration started: %s', $show ),
            sprintf(
                "A %s migration (import #%d) has just started for %s.\n\nSubscribers are being imported now.",
                ucfirst( $platform ),
                $batch_id,
                $show
            )
        );
    },
    10,
    3
);
