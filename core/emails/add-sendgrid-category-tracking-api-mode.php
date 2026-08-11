<?php
// Add SendGrid category tracking when WP Mail SMTP is running in SendGrid API mode

/**
 * SendGrid API-mode category tracking.
 *
 * Requires WP Mail SMTP >= 3.0 with the SendGrid mailer set to "API" mode
 * (Settings → WP Mail SMTP → Advanced → SendGrid → Mailer Type = API).
 * In SMTP-relay mode, use the sibling recipe
 * `add-sendgrid-category-tracking-to-emails` instead.
 */
final class My_Addon_SendGrid_API_Categories {

    /** @var array<string, int|string>|null */
    private static ?array $pending_context = null;

    public static function register(): void {
        add_filter( 'benecaster_email_headers', [ self::class, 'capture_context' ], 10, 4 );
        add_filter( 'wp_mail_smtp_providers_mailer_get_body', [ self::class, 'inject_into_body' ], 10, 2 );
    }

    /**
     * Capture Benecaster's per-email context on its way to wp_mail().
     * The body filter fires deep inside WP Mail SMTP's SendGrid Mailer
     * with no access to the email type / user / show, so we stash it
     * here and read it back in inject_into_body().
     */
    public static function capture_context( array $headers, string $type, int $user_id, int $show_id ): array {
        self::$pending_context = [
            'type'    => $type,
            'user_id' => $user_id,
            'show_id' => $show_id,
        ];
        return $headers;
    }

    /**
     * Merge Benecaster's context onto the outbound SendGrid API body as
     * `categories` (array of strings) and `custom_args` (string=>string map)
     * per SendGrid's /v3/mail/send spec.
     */
    public static function inject_into_body( array $body, string $mailer ): array {
        if ( 'sendgrid' !== $mailer || null === self::$pending_context ) {
            return $body;
        }

        $ctx                   = self::$pending_context;
        self::$pending_context = null; // one-shot; next email starts fresh

        $body['categories'] = array_values( array_unique( array_merge(
            (array) ( $body['categories'] ?? [] ),
            [ 'benecaster', 'benecaster_' . $ctx['type'] ]
        ) ) );

        // custom_args values must be strings per SendGrid's schema.
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
