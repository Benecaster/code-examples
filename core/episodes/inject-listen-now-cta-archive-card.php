<?php
// Inject a "Listen now" CTA button into every archive episode card

add_action(
    'benecaster_after_episode_card_title',
    function ( int $episode_id, int $show_id ): void {
        $permalink = get_permalink( $episode_id );
        ?>
        <a href="<?php echo esc_url( $permalink ); ?>"
           class="benecaster-card-cta benecaster-btn benecaster-btn--sm">
            <?php esc_html_e( 'Listen now', 'my-theme' ); ?>
        </a>
        <?php
    },
    10,
    2
);
