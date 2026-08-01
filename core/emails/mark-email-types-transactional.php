<?php
// Mark add-on email types as transactional so they bypass broadcast opt-out

add_filter( 'benecaster_transactional_email_types', function ( array $types ): array {
    // Ensure our add-on's operational email is never suppressed by broadcast opt-out.
    $types[] = 'my_addon_access_expiry';
    return $types;
} );
