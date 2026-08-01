<?php
// Mirror built-in tier CRUD into an external CRM, billing dashboard, or reporting pipeline

add_action( 'benecaster_membership_tier_created', function ( int $tier_id, array $tier ): void {
    my_crm_upsert_plan( [
        'external_id' => 'benecaster:' . $tier['show_id'] . ':' . $tier['tier_slug'],
        'name'        => $tier['tier_name'],
        'monthly'     => $tier['monthly_price'],
        'annual'      => $tier['annual_price'],
        'active'      => $tier['is_active'],
    ] );
}, 10, 2 );

add_action( 'benecaster_membership_tier_deleted', function ( int $tier_id, int $show_id, string $tier_slug ): void {
    my_crm_deactivate_plan( 'benecaster:' . $show_id . ':' . $tier_slug );
}, 10, 3 );
