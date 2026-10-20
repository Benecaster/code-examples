<?php
// Receive Benecaster webhooks safely — verify the signature and ignore retries you already handled

// A receiver on another WordPress site (any language works the same way).
add_action( 'rest_api_init', function (): void {
    register_rest_route( 'my-crm/v1', '/benecaster', [
        'methods'             => 'POST',
        'permission_callback' => '__return_true',
        'callback'            => function ( WP_REST_Request $request ) {
            $raw      = $request->get_body();
            $expected = 'sha256=' . hash_hmac( 'sha256', $raw, MY_BENECASTER_SECRET );
            if ( ! hash_equals( $expected, (string) $request->get_header( 'x-benecaster-signature' ) ) ) {
                return new WP_REST_Response( null, 401 );
            }

            $delivery = (string) $request->get_header( 'x-benecaster-delivery' );
            if ( get_transient( 'bc_seen_' . md5( $delivery ) ) ) {
                return new WP_REST_Response( null, 200 ); // a retry we already handled
            }
            set_transient( 'bc_seen_' . md5( $delivery ), 1, DAY_IN_SECONDS );

            $event = json_decode( $raw, true );
            if ( 'token.revoked' === $event['event'] && 'admin_revoked' === $event['reason'] ) {
                my_crm_tag( $event['email'], 'removed-by-podcaster' );
            }
            return new WP_REST_Response( null, 200 ); // answer fast; queue heavy work
        },
    ] );
} );
