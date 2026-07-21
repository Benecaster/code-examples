// Redirect feed URLs to pretty permalink format
// Switch from ?token= query-string format to /feed/{token} pretty permalink.
// Add this to functions.php or a site-specific plugin.
add_filter(
    'benecaster_token_url',
    function ( string $url, string $token, int $show_id, int $user_id ): string {
        // Replace https://site.com/podcast-feed/?token=<hex>
        // with   https://site.com/podcast-feed/<hex>
        return home_url( '/podcast-feed/' . $token );
    },
    10,
    4
);
