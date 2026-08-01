<?php
// Replace the episode share links with a custom share card

add_filter(
    'benecaster_episode_share_links',
    function ( array $links, int $episode_id, int $show_id ): array {
        $permalink = get_permalink( $episode_id );
        $title     = rawurlencode( get_the_title( $episode_id ) );

        // Replace default links with a podcast-specific set.
        return [
            [
                'label' => __( 'Share on Threads', 'my-theme' ),
                'url'   => 'https://www.threads.net/intent/post?text=' . $title . '%20' . rawurlencode( $permalink ),
                'class' => 'benecaster-share-threads',
            ],
            [
                'label' => __( 'Copy link', 'my-theme' ),
                'url'   => '#',
                'class' => 'benecaster-share-copy js-copy-link',
            ],
        ];
    },
    10,
    3
);
