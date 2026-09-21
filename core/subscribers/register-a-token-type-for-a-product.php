<?php
// Register a token type for a product

add_action( 'benecaster_boot', function (): void {
    add_filter( 'benecaster_registered_token_types', function ( array $types ): array {
        $types['my-addon_patron'] = [
            'label'      => __( 'Patron', 'my-addon' ),
            'behaves_as' => 'subscriber',   // or 'follower'
        ];

        return $types;
    } );
} );
