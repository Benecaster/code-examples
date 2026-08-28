<?php
// Add a quarterly cadence to an existing tier

add_action( 'benecaster_boot', function ( \Benecaster\Container $container ): void {
    // Resolve the tier by its stable slug — do not hardcode primary keys.
    $tiers = $container->make( \Benecaster\Membership\MembershipTierRepository::class );
    $tier  = $tiers->find_by_slug( 'gold' );
    if ( null === $tier ) {
        return;
    }

    $prices = $container->make( \Benecaster\Membership\MembershipPriceRepository::class );

    // Idempotency: bail if a 3-month cadence already exists for this tier
    // so re-running the setup script does not create duplicate rows.
    foreach ( $prices->find_by_tier( (int) $tier['id'] ) as $existing ) {
        if ( 'month' === $existing['interval_unit'] && 3 === (int) $existing['interval_count'] ) {
            return;
        }
    }

    // Insert the new Price row. StripeTierProvisioner picks this up on the
    // next reconciliation and mints the corresponding Stripe Price against
    // the tier's existing Stripe Product — no admin visit required.
    $prices->insert( [
        'tier_id'        => (int) $tier['id'],
        'cadence_label'  => 'Quarterly',
        'interval_unit'  => 'month',
        'interval_count' => 3,
        'amount_cents'   => 1500,
        'currency'       => 'USD',
        'is_default'     => false,
        'sort_order'     => 15,
    ] );
} );
