<?php
// Substitute the default "Sold out" button on a capped buy-up with a custom waitlist

add_filter( 'benecaster_buyup_soldout_display', function ( string $html, int $buyup_id, int $user_id ): string {
    // Return a "Join waitlist" form that posts to a custom REST endpoint.
    ob_start();
    ?>
    <form class="my-waitlist" method="post" action="/wp-json/my-plugin/v1/waitlist">
        <input type="hidden" name="buyup_id" value="<?php echo esc_attr( (string) $buyup_id ); ?>">
        <button type="submit"><?php esc_html_e( 'Join waitlist', 'my-plugin' ); ?></button>
    </form>
    <?php
    return (string) ob_get_clean();
}, 10, 3 );
