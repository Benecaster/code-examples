<?php
// Keep staging test data out of your production CRM and email lists

add_action(
    'benecaster_subscription_activated',
    function ( int $user_id, int $show_id, string $tier_slug, string $source ): void {
        if ( ! benecaster_is_production_site() ) {
            return; // Don't push test subscribers to the production CRM.
        }
        my_crm_tag_contact( get_userdata( $user_id )->user_email, [
            'benecaster_subscriber' => true,
            'tier'                  => $tier_slug,
            'source'                => $source,
        ] );
    },
    10, 4
);
