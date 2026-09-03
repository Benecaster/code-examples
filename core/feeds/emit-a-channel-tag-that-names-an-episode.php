<?php
// Add a channel-level feed tag that names an episode, safely

use Benecaster\Episode\EpisodeMeta;
use Benecaster\Feed\Namespaces\TierAwareFeedNamespaceInterface;

class MyHighlightsNamespace implements TierAwareFeedNamespaceInterface {

    public function get_xmlns(): array {
        return [ 'myns' => 'https://example.com/ns/1.0' ];
    }

    // No tier context here, so advertise no episodes at all rather than guess.
    public function channel_tags( int $show_id ): array {
        return $this->channel_tags_for_tier( $show_id, '', [] );
    }

    public function channel_tags_for_tier( int $show_id, string $tier_slug, array $available_episode_ids ): array {
        // Empty means "this tier can reach nothing", NOT "no filter applied".
        if ( empty( $available_episode_ids ) ) {
            return [];
        }

        $frags = [];

        foreach ( $available_episode_ids as $episode_id ) {
            $episode_id = (int) $episode_id;

            if ( ! get_post_meta( $episode_id, '_my_highlight', true ) ) {
                continue;
            }

            $ep_meta = new EpisodeMeta( $episode_id );

            // Pass the URL through the same filters the <enclosure> uses, or a
            // site running the download proxy gets its raw host URL republished
            // in the channel — the one place every recipient sees it.
            $url = (string) apply_filters(
                'benecaster_feed_enclosure_url',
                $ep_meta->get_audio_url(),
                $episode_id,
                $show_id,
                $tier_slug
            );

            if ( '' === $url ) {
                continue;
            }

            $frags[] = '<myns:highlight url="' . esc_url( $url ) . '"/>' . "\n";
        }

        return $frags;
    }

    public function episode_tags( int $episode_id, int $show_id ): array {
        return [];
    }
}

add_filter( 'benecaster_feed_namespaces', function ( array $handlers ): array {
    $handlers[] = new MyHighlightsNamespace();
    return $handlers;
} );
