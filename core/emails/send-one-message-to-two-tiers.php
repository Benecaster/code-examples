<?php
// Send one message to two tiers of a show

$broadcast_id = benecaster_send_broadcast(
    $show_id,
    [ 'tier:gold', 'tier:silver' ],          // A listener in both is mailed once.
    __( 'Live show this Friday', 'my-addon' ),
    '<p>Hi {{subscriber_name}},</p><p>We record live on Friday at 8pm.</p>',
    __( 'Join us live on Friday', 'my-addon' ) // Inbox preview line, or null.
);
if ( 0 === $broadcast_id ) {
    // Refused: not a show, no audience, or an empty subject or body.
}

// Elsewhere, registered when your plugin loads — NOT next to the call above.
// The recipients are queued in the background, so this fires in a later
// WP-Cron request. Opted-out listeners are skipped, not errors.
add_action( 'plugins_loaded', static function (): void {
    add_action( 'benecaster_after_broadcast_send', static function ( int $id, int $show_id, array $counts ): void {
        error_log( sprintf( 'Broadcast %d queued %d, %d had opted out.', $id, $counts['queued'], $counts['suppressed'] ) );
    }, 10, 3 );
} );
