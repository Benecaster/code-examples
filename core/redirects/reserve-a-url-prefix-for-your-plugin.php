<?php
// Reserve a URL prefix for your plugin

add_filter( 'benecaster_reserved_permalink_prefixes', function ( array $prefixes ): array {
    $prefixes[] = 'shop';   // my-addon serves /shop/{slug}

    return $prefixes;
} );
