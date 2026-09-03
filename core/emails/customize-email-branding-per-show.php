<?php
// Customize Email Header Branding Per Show

add_filter(
    'benecaster_email_wrapper_args',
    function ( array $args, string $email_type, int $show_id ): array {
        // Admin emails keep the default styling.
        if ( ! empty( $args['is_admin_email'] ) ) {
            return $args;
        }

        $branding = [
            12 => [ 'accent' => '#1a5f7a', 'logo' => 'https://example.com/logo-show-a.png' ],
            34 => [ 'accent' => '#7a1a2f', 'logo' => 'https://example.com/logo-show-b.png' ],
        ];

        if ( ! isset( $branding[ $show_id ] ) ) {
            return $args;
        }

        $args['accent_color'] = $branding[ $show_id ]['accent'];
        $args['logo_url']     = $branding[ $show_id ]['logo'];
        $args['footer_text']  = $args['show_name'] . ' — thanks for listening.';

        return $args;
    },
    10,
    3
);
