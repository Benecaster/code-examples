<?php
// Redirect the account page URL to a custom path

// Point all account page links to a custom path, e.g. /my-podcast-portal/
add_filter(
    'benecaster_account_page_url',
    function ( string $url, int $show_id ): string {
        return home_url( '/my-podcast-portal/' );
    },
    10,
    2
);
