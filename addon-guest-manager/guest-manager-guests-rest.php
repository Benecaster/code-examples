<?php
// Read, create, change or delete guests from code, as the Guests screen does

// Mirror every guest edit into a CRM, and drop the record when the guest is deleted.
add_action( 'benecaster_guest_manager_after_save_guest', function ( int $guest_id, array $fields, bool $created ): void {
    my_crm_upsert_contact( 'guest-' . $guest_id, $fields );
}, 10, 3 );
add_action( 'benecaster_guest_manager_after_delete_guest', function ( int $guest_id ): void {
    my_crm_delete_contact( 'guest-' . $guest_id );
} );

// Create a guest from a booking form, then give them a photo already in the media library.
$request = new WP_REST_Request( 'POST', '/benecaster-guest-manager/v1/guests' );
$request->set_body_params( [
    'name'         => 'Alice Smith',
    'title'        => 'Founder',
    'organization' => 'Acme Labs',
    'website'      => 'https://alice.example',
    'social'       => [ [ 'platform' => 'LinkedIn', 'url' => 'https://linkedin.example/in/alice' ] ],
] );
$guest = rest_do_request( $request )->get_data();

$update = new WP_REST_Request( 'PATCH', '/benecaster-guest-manager/v1/guests/' . $guest['id'] );
$update->set_body_params( [ 'photo_id' => 381 ] );
rest_do_request( $update );
