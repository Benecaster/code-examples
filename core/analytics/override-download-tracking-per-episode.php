<?php
// Override whether a specific episode's downloads get counted

add_filter( 'benecaster_episode_download_tracking_enabled', function ( bool $enabled, int $episode_id ): bool {
    // Never track downloads for episodes tagged "sponsor-preview" —
    // regardless of what the show or episode setting says.
    if ( has_term( 'sponsor-preview', 'episode_tag', $episode_id ) ) {
        return false;
    }

    return $enabled;
}, 10, 2 );
