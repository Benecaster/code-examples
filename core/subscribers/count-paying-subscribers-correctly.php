<?php
// Which subscriber count is the paying one

// The paying count for one show, and across every show on the site.
$count      = benecaster_count_paying_subscribers( $show_id );
$site_count = benecaster_count_paying_subscribers_site_wide();

// For contrast: every active token, followers and free-tier members
// included. An audience size, not a paying count.
$audience = benecaster_get_subscriber_count( $show_id );

printf( '%d paying of %d listeners', $count, $audience );
