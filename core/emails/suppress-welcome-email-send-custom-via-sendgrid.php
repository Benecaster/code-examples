// Suppress welcome email and send custom version via SendGrid
add_filter(
    'benecaster_email_should_send',
    function ( bool $should, string $type, string $to, int $user_id, int $show_id ): bool {
        if ( 'welcome' !== $type ) {
            return $should;
        }
        wp_remote_post(
            'https://api.sendgrid.com/v3/mail/send',
            [
                'timeout'  => 5,
                'blocking' => false,
                'headers'  => [
                    'Content-Type'  => 'application/json',
                    'Authorization' => 'Bearer ' . SENDGRID_API_KEY,
                ],
                'body'     => wp_json_encode( [
                    'from'                    => [ 'email' => get_option( 'admin_email' ), 'name' => get_bloginfo( 'name' ) ],
                    'personalizations'        => [ [
                        'to'                    => [ [ 'email' => $to ] ],
                        'dynamic_template_data' => [
                            'first_name' => get_userdata( $user_id )->first_name,
                            'show_name'  => get_the_title( $show_id ),
                        ],
                    ] ],
                    'template_id'             => 'd-your-sendgrid-template-id',
                ] ),
            ]
        );
        return false; // Benecaster's own welcome is skipped.
    },
    10,
    5
);
