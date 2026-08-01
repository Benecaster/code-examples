<?php
// Keep a capped-cohort tier purchasable via direct link while hiding it from the public subscribe picker

add_filter( 'benecaster_subscribe_tiers', function ( array $rows, int $show_id ): array {
    return array_values( array_filter( $rows, function ( array $tier ): bool {
        return 'founding-member' !== $tier['tier_slug'];
    } ) );
}, 10, 2 );
