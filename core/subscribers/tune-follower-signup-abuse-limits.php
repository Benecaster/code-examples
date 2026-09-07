<?php
// Tune the follower signup abuse limits — and know what turning them off costs

/**
 * Loosen the limits for a site running a signup drive.
 *
 * ⚠⚠ A limit of 0 or less DISABLES that limit. On a form that always
 * reports success and mails on every submission, that is an open relay.
 *
 * @param array{address_limit:int, ip_limit:int, window:int} $limits
 */
add_filter( 'benecaster_follower_signup_limits', function ( array $limits, int $show_id ): array {
    if ( 42 === $show_id ) {
        $limits['ip_limit'] = 30;
    }

    return $limits;
}, 10, 2 );

/**
 * Log refusals rather than showing them.
 *
 * ⚠ The submitter is told nothing, on purpose. A visible "too many
 * requests" on a per-address limit tells a stranger that an address was
 * recently submitted here.
 *
 * @param string $reason 'address' or 'ip'.
 */
add_action( 'benecaster_follower_signup_throttled', function ( int $show_id, string $reason ): void {
    error_log( "benecaster: follower signup throttled on show {$show_id} ({$reason})" );
}, 10, 2 );

/**
 * Count the real visitor IP when the site sits behind a reverse proxy.
 *
 * ⚠⚠ Only safe because THIS site's proxy sets and OVERWRITES this header.
 * Reading a client-supplied header instead disables every per-IP limit in
 * the plugin, silently — the counters still tick, every request just looks
 * like a new visitor.
 */
add_filter( 'benecaster_rate_limit_client_ip', function ( string $ip ): string {
    return isset( $_SERVER['HTTP_CF_CONNECTING_IP'] )
        ? (string) $_SERVER['HTTP_CF_CONNECTING_IP']
        : $ip;
} );

/**
 * Writing your own limit — reuse the shared store, do not hand-roll one.
 */
add_action( 'init', function (): void {
    $store = new \Benecaster\Support\RateLimitStore();

    // ⚠ Hash anything personal BEFORE it becomes part of a key: transient
    // names land in wp_options on a site with no object cache.
    $key = 'my_addon_' . $store->hash( $store->client_ip() );

    if ( $store->hit( $key, 5, HOUR_IN_SECONDS ) ) {
        return; // Over quota. Refuse quietly.
    }

    my_addon_do_the_expensive_thing();
} );
