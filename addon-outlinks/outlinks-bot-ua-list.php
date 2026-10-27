<?php
// Count your own monitor or in-house crawler as a bot in Outlinks click counts

add_filter( 'benecaster_outlinks_bot_ua_list', function ( array $ua_patterns ): array {
    $ua_patterns[] = 'acme-uptime'; // Append: the array you return REPLACES the list.
    return $ua_patterns;
} );
