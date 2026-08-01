<?php
// Fetch a subscriber's active subscriptions from a headless or native client

// WordPress: fetch own subscriptions server-side (e.g. in a REST proxy add-on)
$response = wp_remote_get(
    rest_url( 'benecaster/v1/account/subscriptions' ),
    [
        'cookies' => $_COOKIE, // forward logged-in user's cookies
    ]
);
$data = json_decode( wp_remote_retrieve_body( $response ), true );
foreach ( $data['items'] as $sub ) {
    // $sub['show_title'], $sub['tier_name'], $sub['token_prefix'] etc.
}
