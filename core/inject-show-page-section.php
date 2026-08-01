<?php
// Add a Custom Section to the Show Page

add_action(
    'benecaster_after_show_episode_list',
    function ( int $show_id ): void {
        $newsletter_url = get_post_meta( $show_id, '_my_newsletter_url', true );
        if ( ! $newsletter_url ) {
            return;
        }
        printf(
            '<div class="my-show-newsletter"><h3>%s</h3><a href="%s" class="benecaster-btn">%s</a></div>',
            esc_html__( 'Stay in the loop', 'my-plugin' ),
            esc_url( $newsletter_url ),
            esc_html__( 'Subscribe to the newsletter', 'my-plugin' )
        );
    },
    10,
    1
);
