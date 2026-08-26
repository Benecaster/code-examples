<?php
// Show a teaser card for locked episodes

// Replace locked-episode markup with a "first 40 words + subscribe CTA" teaser card.
//
// Fires from all three episode-listing shortcodes — one callback covers
// every surface. Includes the show ID so the CTA link can point at the
// right per-show subscribe page.
add_filter( 'benecaster_episode_item_output', function ( string $html, int $episode_id, int $show_id, string $user_tier, bool $is_locked ): string {
    if ( ! $is_locked ) {
        return $html;
    }

    $title       = get_the_title( $episode_id );
    $permalink   = get_permalink( $episode_id );
    $description = get_post_meta( $episode_id, '_benecaster_episode_description_rss', true );
    $teaser      = wp_trim_words( wp_strip_all_tags( (string) $description ), 40, '…' );

    // Point the CTA at the show's Subscribe shortcode landing page.
    // Adjust the URL to whatever your site uses for subscription checkout.
    $subscribe_url = home_url( '/subscribe/?show=' . $show_id );

    ob_start();
    ?>
    <div class="my-episode-teaser">
        <h3 class="my-episode-teaser__title"><?php echo esc_html( $title ); ?></h3>
        <p class="my-episode-teaser__description"><?php echo esc_html( $teaser ); ?></p>
        <p class="my-episode-teaser__cta">
            <a href="<?php echo esc_url( $subscribe_url ); ?>">
                Subscribe to hear this episode
            </a>
            &nbsp;·&nbsp;
            <a href="<?php echo esc_url( $permalink ); ?>">Episode page</a>
        </p>
    </div>
    <?php
    return (string) ob_get_clean();
}, 10, 5 );
