<?php
// Read Benecaster's analytics numbers instead of copying its SQL

add_action( 'rest_api_init', function () {
    register_rest_route( 'my-analytics/v1', '/shows/(?P<id>\d+)/winback', [
        'methods'             => 'GET',
        'permission_callback' => fn() => current_user_can( 'manage_options' ), // it names users
        'callback'            => function ( WP_REST_Request $request ) {
            $show_id = (int) $request['id'];

            $leads = benecaster_get_winback_leads( $show_id, [ 'limit' => 50 ] );
            if ( null === $leads ) {
                return [ 'logging' => false ]; // log switched off: no data, not zero
            }

            return [
                'logging' => true,
                'leads'   => array_map( fn( $lead ) => [
                    'user'      => get_userdata( $lead['user_id'] )?->display_name,
                    'tier'      => $lead['tier_slug'],
                    'last_seen' => wp_date( 'j M Y, H:i', strtotime( $lead['last_polled_at'] . ' UTC' ) ),
                    'app'       => $lead['app'],
                ], $leads ),
                // A year of tracked downloads by app — the daily totals are included.
                'by_app'  => benecaster_get_downloads_by( 'app', $show_id, [
                    'date_from' => gmdate( 'Y-m-d', strtotime( '-1 year' ) ),
                ] ),
            ];
        },
    ] );
} );
