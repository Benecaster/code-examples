// Customize the Upgrade Prompt for a Specific Show
add_filter(
    'benecaster_upgrade_prompt_html',
    function ( string $html, int $episode_id, int $show_id, string $required_tier, string $user_tier ): string {
        if ( $show_id !== 42 ) {
            return $html;
        }
        return sprintf(
            '<p class="my-upgrade">This episode is for %s subscribers. <a href="/subscribe/">Upgrade your plan →</a></p>',
            esc_html( $required_tier )
        );
    },
    10,
    5
);
