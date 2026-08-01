<?php
// Add a "Need help?" support link above the feed URL section on the account page

add_action( 'benecaster_before_account_feed_url', function ( int $show_id, int $user_id ): void {
    echo '<p class="my-support-note">';
    printf(
        /* translators: %s: link to support page */
        esc_html__( 'Having trouble? %s', 'my-addon' ),
        '<a href="' . esc_url( get_permalink( get_page_by_path( 'support' ) ) ) . '">'
        . esc_html__( 'Visit our support centre', 'my-addon' )
        . '</a>'
    );
    echo '</p>';
}, 10, 2 );
