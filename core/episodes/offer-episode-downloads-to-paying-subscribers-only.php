<?php
// Offer episode downloads to paying subscribers only

add_filter( 'benecaster_show_episode_download', function ( bool $show, int $episode_id, ?int $user_id, ?string $user_tier ): bool {
    return $show && null !== $user_tier;
}, 10, 4 );
