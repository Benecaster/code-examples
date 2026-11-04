<?php
// Chart a show's feed health day by day

add_action( 'rest_api_init', function () {
    register_rest_route( 'my-analytics/v1', '/shows/(?P<id>\d+)/feed-health', [
        'methods'             => 'GET',
        'permission_callback' => fn() => current_user_can( 'manage_options' ),
        'callback'            => function ( WP_REST_Request $request ) {
            $rows = benecaster_get_feed_health_history( (int) $request['id'], [
                'date_from' => gmdate( 'Y-m-d', strtotime( '-90 days' ) ), // UTC days, inclusive
            ] );

            // Key by day so a day with no row stays a gap, never a green day.
            $by_day = array_column( $rows, null, 'date' );
            $points = [];
            for ( $t = strtotime( '-90 days' ); $t <= time(); $t += DAY_IN_SECONDS ) {
                $day      = gmdate( 'Y-m-d', $t );
                $row      = $by_day[ $day ] ?? null;
                $points[] = [
                    'date'     => $day,
                    'state'    => null === $row ? 'unchecked' : ( $row['is_valid'] ? 'valid' : 'invalid' ),
                    'reason'   => $row['first_error_code'] ?? null,
                    'episodes' => $row['episode_count'] ?? null,
                    // null = this show does not sync from an external feed.
                    'sync'     => null === ( $row['sync_runs'] ?? null )
                        ? null
                        : [ 'runs' => $row['sync_runs'], 'failed' => $row['sync_failures'] ],
                ];
            }
            return $points;
        },
    ] );
} );
