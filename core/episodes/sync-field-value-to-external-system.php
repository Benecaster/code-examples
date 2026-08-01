<?php
// Sync a custom field value to an external system on save

add_action( 'benecaster_field_value_saved', function (
    int    $field_id,
    int    $object_id,
    string $cpt_slug,
    mixed  $value
): void {
    if ( 'benecaster_guest' !== $cpt_slug ) {
        return;
    }

    $crm_field_map = [
        42 => 'crm_booking_url',
        43 => 'crm_preferred_name',
    ];
    if ( ! isset( $crm_field_map[ $field_id ] ) ) {
        return;
    }

    $guest_id = get_post_meta( $object_id, '_my_crm_contact_id', true );
    if ( ! $guest_id ) {
        return;
    }

    wp_remote_post( 'https://api.my-crm.example.com/contacts/' . $guest_id, [
        'method'   => 'PATCH',
        'headers'  => [ 'Content-Type' => 'application/json', 'Authorization' => 'Bearer ' . MY_CRM_API_KEY ],
        'body'     => wp_json_encode( [ $crm_field_map[ $field_id ] => $value ] ),
        'timeout'  => 5,
        'blocking' => false,
    ] );
}, 10, 4 );
