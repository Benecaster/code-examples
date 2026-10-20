<?php
// Let Zapier, Make or a CRM call your add-on

add_action( 'benecaster_boot', function ( \Benecaster\Container $container ) {
    benecaster_register_addon( 'my-addon', static function (): void {
        benecaster_register_integration_action( 'my-addon', 'my-addon.booking.paid', [
            'label'   => __( 'A booking was paid elsewhere', 'my-addon' ),
            'fields'  => [
                'booking_id' => [ 'type' => 'integer', 'required' => true, 'description' => 'From my-addon.booking.confirmed' ],
                'invoice_id' => [ 'type' => 'string', 'required' => true ],
            ],
            'handler' => static function ( array $data, int $show_id, int $user_id ): array|\WP_Error {
                $booking = get_post( $data['booking_id'] ); // already an int, even if Zapier sent "381"
                if ( ! $booking || (int) get_post_meta( $booking->ID, '_show_id', true ) !== $show_id ) {
                    return new \WP_Error( 'unknown_booking', __( 'No such booking on this show.', 'my-addon' ), [ 'status' => 404 ] );
                }
                update_post_meta( $booking->ID, '_invoice_id', $data['invoice_id'] );
                return [ 'booking_id' => $booking->ID, 'status' => 'paid' ]; // ids, not personal data
            },
        ] );
    } );
} );
