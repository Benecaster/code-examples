<?php
// Add a custom bridge card to the wizard Subscription step

add_filter( 'benecaster_setup_wizard_bridge_options', function ( array $options ): array {
    if ( class_exists( 'MyMembershipPlugin' ) ) {
        $options[] = [
            'slug' => 'my-membership-plugin',
            'name' => 'My Membership Plugin',
        ];
    }
    return $options;
} );
