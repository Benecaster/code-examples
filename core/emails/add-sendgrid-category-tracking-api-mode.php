<?php
// Add SendGrid category tracking in API delivery mode

final class My_Addon_SendGrid_API_Categories {

    /** @var array<string, int|string>|null */
    private static ?array $pending_context = null;

    public static function register(): void {
        add_filter( 'benecaster_email_headers', [ self::class, 'capture_context' ], 10, 4 );
        add_filter( 'wp_mail_smtp_providers_mailer_get_body', [ self::class, 'inject_into_body' ], 10, 2 );
    }

    public static function capture_context( array $headers, string $type, int $user_id, int $show_id ): array {
        self::$pending_context = [
            'type'    => $type,
            'user_id' => $user_id,
            'show_id' => $show_id,
        ];
        return $headers;
    }

    public static function inject_into_body( array $body, string $mailer ): array {
        if ( 'sendgrid' !== $mailer || null === self::$pending_context ) {
            return $body;
        }

        $ctx                   = self::$pending_context;
        self::$pending_context = null;

        $body['categories'] = array_values( array_unique( array_merge(
            (array) ( $body['categories'] ?? [] ),
            [ 'benecaster', 'benecaster_' . $ctx['type'] ]
        ) ) );

        $body['custom_args'] = array_merge(
            (array) ( $body['custom_args'] ?? [] ),
            [
                'benecaster_type' => $ctx['type'],
                'user_id'         => (string) $ctx['user_id'],
                'show_id'         => (string) $ctx['show_id'],
            ]
        );

        return $body;
    }
}

add_action( 'init', [ My_Addon_SendGrid_API_Categories::class, 'register' ] );
