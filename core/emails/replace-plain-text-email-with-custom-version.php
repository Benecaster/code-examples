// Replace auto-generated plain text email with custom version
add_filter(
    'benecaster_email_body_text',
    function ( string $text, string $type, array $context ): string {
        if ( 'welcome' !== $type ) {
            return $text;
        }
        $show_title = (string) ( $context['show_title'] ?? '' );
        $feed_url   = (string) ( $context['feed_url'] ?? '' );
        return sprintf(
            "Welcome to %s!\n\n"
            . "Your private podcast feed is ready. Paste this URL into your podcast player of choice:\n\n"
            . "  %s\n\n"
            . "Need help? Reply to this email — we read every one.\n",
            $show_title,
            $feed_url
        );
    },
    10,
    3
);
