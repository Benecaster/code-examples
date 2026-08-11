<?php
// Add SendGrid category tracking to all emails (SMTP relay mode)

add_filter(
    'benecaster_email_headers',
    function ( array $headers, string $type, int $user_id, int $show_id ): array {
        $smtpapi = [
            'category'    => [ 'benecaster', 'benecaster_' . $type ],
            'unique_args' => [
                'benecaster_type' => $type,
                'user_id'         => (string) $user_id,
                'show_id'         => (string) $show_id,
            ],
        ];
        $headers[] = 'X-SMTPAPI: ' . wp_json_encode( $smtpapi );
        return $headers;
    },
    10,
    4
);
