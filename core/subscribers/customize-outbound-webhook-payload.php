<?php
// Mutate or block outgoing webhook payloads per event

// Add a tenant identifier to every outbound webhook.
add_filter( 'benecaster_webhook_payload', function ( ?array $payload, string $event ): ?array {
    if ( null === $payload ) {
        return null;
    }
    $payload['tenant'] = get_option( 'my_tenant_id' );
    return $payload;
}, 10, 2 );

// Skip webhook dispatch for a specific show.
add_filter( 'benecaster_webhook_payload', function ( ?array $payload ): ?array {
    if ( null === $payload || ( $payload['show_id'] ?? 0 ) === 42 ) {
        return null;
    }
    return $payload;
} );
