<?php
// Inspect or log where an Outlinks click is about to send a visitor

add_action( 'benecaster_outlinks_before_redirect', function ( string $slug, ?int $episode_id, ?string $country_code, array $redirect_data ): void {
    if ( str_contains( $redirect_data['target_url'], 'tag=' ) ) {
        my_affiliate_log( $slug, $country_code, $redirect_data['target_url'] );
    }
}, 10, 4 );
