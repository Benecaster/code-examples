<?php
// Replace the locked episode prompt with an inline tier comparison

add_filter( 'benecaster_locked_content_message', function ( string $html, int $episode_id, string $required_tier, string $user_tier ): string {
    $show_id = wp_get_post_parent_id( $episode_id );
    ob_start();
    ?>
    <div class="my-locked-prompt">
        <p><?php esc_html_e( 'This episode is for paying subscribers.', 'my-theme' ); ?></p>
        <?php if ( $user_tier !== '' ) : ?>
            <p><?php esc_html_e( 'Upgrade your plan to access it.', 'my-theme' ); ?></p>
        <?php endif; ?>
        <a href="<?php echo esc_url( get_permalink( $show_id ) ); ?>" class="button">
            <?php esc_html_e( 'See subscription options', 'my-theme' ); ?>
        </a>
    </div>
    <?php
    return ob_get_clean();
}, 10, 4 );
