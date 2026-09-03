<?php
// Add or remove languages offered in Settings and the setup wizard

add_filter( 'benecaster_available_locales', function ( array $locales ): array {
    $locales[] = [
        'code'         => 'es_AR',
        'english_name' => 'Spanish (Argentina)',
        'native_name'  => 'Español (Argentina)',
    ];
    return $locales;
} );
