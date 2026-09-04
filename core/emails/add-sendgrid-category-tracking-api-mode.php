<?php
// Add SendGrid category tracking in API delivery mode

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
        add_action( 'benecaster_email_queue_before_send', [ self::class, 'capture_context' ], 10, 4 );
        add_filter( 'wp_mail_smtp_providers_mailer_get_body', [ self::class, 'inject_into_body' ], 10, 2 );
    }

    /**
     * Capture Benecaster's per-email context immediately before the send.
     *
     * The body filter fires deep inside WP Mail SMTP's SendGrid Mailer with
     * no access to the email type / user / show, so stash it here and read
     * it back in inject_into_body().
     *
     * @param array{to: string, subject: string, body_html: string, headers: string[]} $message
     */
    public static function capture_context( array $message, string $email_type, int $show_id, int $user_id ): void {
        self::$pending_context = [
            'type'    => $email_type,
            'user_id' => $user_id,
            'show_id' => $show_id,
        ];
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
        self::$pending_context = null; // one-shot; the next email starts fresh

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
