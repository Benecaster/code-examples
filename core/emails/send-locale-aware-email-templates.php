<?php
// Send locale-aware email templates to subscribers in their own language

// Normalize partial locales and map unsupported ones to English fallback.
add_filter( 'benecaster_email_template_locale', function ( string $locale, ?int $user_id, ?int $show_id, string $email_type ): string {
    // Supported translated locales for this add-on.
    $supported = [ 'fr_FR', 'de_DE', 'es_ES', 'pt_BR' ];

    // Accept just the language part (e.g. 'fr' → 'fr_FR').
    if ( strlen( $locale ) === 2 ) {
        foreach ( $supported as $full ) {
            if ( str_starts_with( $full, $locale . '_' ) ) {
                return $full;
            }
        }
    }

    // Return '' for unsupported locales so Benecaster falls back to the default template.
    return in_array( $locale, $supported, true ) ? $locale : '';
}, 10, 4 );
