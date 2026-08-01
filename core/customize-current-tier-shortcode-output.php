<?php
// Customise [benecaster_current_tier] output

add_filter(
    'benecaster_current_tier_output',
    function ( string $output, int $show_id, ?string $tier_slug, ?\WP_User $user, array $atts ): string {
        if ( null === $tier_slug || null === $user ) {
            return $output; // guest / no token — respect the shortcode's fallback
        }
        return sprintf(
            /* translators: 1: first name, 2: tier display name */
            __( 'Welcome back, %1$s — your current tier is %2$s.', 'my-addon' ),
            esc_html( $user->display_name ),
            esc_html( $output )
        );
    },
    10,
    5
);
