<?php
// Redirect feed URLs to pretty permalink format

// Serve subscriber feeds at /listen/{token}/ instead.
// Add this to functions.php or a site-specific plugin.
add_filter(
    'benecaster_token_url',
    function ( string $url, string $token, int $show_id, int $user_id ): string {
        return home_url( '/listen/' . rawurlencode( $token ) . '/' );
    },
    10,
    4
);

// A custom shape needs its own rewrite rule, routed to Benecaster's feed
// controller by the benecaster_feed query vars. With no show slug in the
// URL, the feed takes the show from the token. Re-save Settings ->
// Permalinks once after adding it.
add_action( 'init', function (): void {
    add_rewrite_rule(
        '^listen/([^/]+)/?$',
        'index.php?benecaster_feed=1&benecaster_feed_token=$matches[1]',
        'top'
    );
} );
