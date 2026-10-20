<?php
// Show the podcaster's inactivity threshold in your add-on, read-only, with a link to change it

$days = benecaster_get_engagement_threshold( $show_id ); // includes any filter

printf(
    '<p>%s <a href="%s">%s</a></p>',
    esc_html( sprintf(
        /* translators: %d: number of days */
        _n( 'Listeners are tagged inactive after %d day without checking the feed.', 'Listeners are tagged inactive after %d days without checking the feed.', $days, 'my-addon' ),
        $days
    ) ),
    esc_url( admin_url( 'admin.php?page=benecaster#/shows/' . $show_id . '/settings/subscription' ) ),
    esc_html__( 'Change it in Show Settings', 'my-addon' )
);
