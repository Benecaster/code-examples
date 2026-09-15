<?php
// Import a follower list from code

add_action( 'benecaster_boot', function ( \Benecaster\Container $container ): void {
    if ( ! defined( 'WP_CLI' ) || ! WP_CLI ) {
        return;
    }

    \WP_CLI::add_command( 'my-addon import-followers', function ( array $args, array $assoc ) use ( $container ): void {
        $show_id   = absint( $assoc['show'] ?? 0 );
        $addresses = file( (string) ( $args[0] ?? '' ), FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES ) ?: [];

        $report = $container
            ->make( \Benecaster\Membership\BulkEnrollmentProcessor::class )
            ->enroll( $addresses, $show_id, '', token_type: 'follower' );

        foreach ( $report['rows'] as $row ) {
            if ( 'follower_cap_reached' === ( $row['message'] ?? '' ) ) {
                \WP_CLI::warning( "{$row['email']}: follower limit reached — connect the show to add more." );
            }
        }

        \WP_CLI::success( sprintf( 'Added %d, already on the show %d, skipped %d, errors %d.',
            $report['enrolled'], $report['already_enrolled'], $report['skipped'], $report['errors'] ) );
    } );
} );
