<?php
// Use a non-USD currency for buy-ups in a specific market

add_filter( 'benecaster_buyup_currency', function ( string $default, int $buyup_id ): string {
    // Use GBP for buy-ups whose token type starts with "uk_".
    $repo  = new \Benecaster\Membership\BuyupRepository();
    $buyup = $repo->find( $buyup_id );
    if ( $buyup && str_starts_with( (string) $buyup['token_type'], 'uk_' ) ) {
        return 'gbp';
    }
    return $default;
}, 10, 2 );
