<?php
// Send migrated subscribers to your own landing page

add_filter(
    'benecaster_migration_checkout_url',
    function ( string $url, int $show_id, ?string $mapped_tier_slug ): string {
        if ( 123 !== $show_id ) {
            return $url;
        }

        // Keep the tier argument: it lists the tier they used to pay for first.
        return add_query_arg(
            'benecaster_migration_tier',
            rawurlencode( (string) $mapped_tier_slug ),
            home_url( '/welcome-back/' )
        );
    },
    10,
    3
);
