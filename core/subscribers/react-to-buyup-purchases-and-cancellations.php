<?php
// Hook a subscriber's buy-up purchase/cancellation to grant extra benefits or send an email

add_action( 'benecaster_buyup_purchased', function ( int $user_id, int $buyup_id, int $show_id, string $item_id ): void {
    // Send the subscriber a transcript bundle link via a separate email.
    my_addon_send_transcript_welcome( $user_id, $buyup_id );
}, 10, 4 );
