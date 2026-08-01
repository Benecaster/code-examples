<?php
// Add SendGrid category tracking to all emails

add_filter(
    'benecaster_email_headers',
    function ( array $headers, string $type, string $to, array $context ): array {
        $smtpapi = [
            'category'      => [ 'benecaster', 'benecaster_' . $type ],
            'unique_args'   => [
                'benecaster_type' => $type,
                'show_id'         => (int) ( $context['show_id'] ?? 0 ),
            ],
        ];
        $headers[] = 'X-SMTPAPI: ' . wp_json_encode( $smtpapi );
        return $headers;
    },
    10,
    4
);
