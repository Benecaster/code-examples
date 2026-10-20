<?php
// Send your add-on's own events through Benecaster's webhook

add_action( 'benecaster_boot', function ( \Benecaster\Container $container ) {
    benecaster_register_addon( 'my-addon', static function (): void {
        benecaster_register_webhook_event( 'my-addon', 'my-addon.booking.confirmed', [
            'label' => __( 'A booking is confirmed', 'my-addon' ),
        ] );

        add_action( 'my_addon_booking_confirmed', static function ( int $booking_id, int $show_id, int $user_id ): void {
            benecaster_send_webhook_event( 'my-addon', 'my-addon.booking.confirmed', $show_id, [
                'booking_id' => $booking_id,             // your record id, as {noun}_id
                'starts_at'  => gmdate( 'c', (int) get_post_meta( $booking_id, 'starts_at', true ) ),
            ], $user_id );                               // 0 when no WordPress user is involved
        }, 10, 3 );
    } );
} );
