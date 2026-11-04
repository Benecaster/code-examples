<?php
// Add a line beside an episode's references in its feed show notes

add_filter( 'benecaster_episode_references_html', function ( string $html, array $refs, int $episode_id, int $show_id, string $context ): string {
    // In 'rss' this runs once per tier when the feed is compiled, and the
    // result is cached for every listener: decide from the episode, never the user.
    $has_affiliate = (bool) array_filter( $refs, static fn( $r ) => str_contains( (string) $r['url'], 'tag=' ) );
    if ( ! $has_affiliate ) {
        return $html;
    }
    return '<p>' . esc_html__( 'Some of these links earn us a commission.', 'myplugin' ) . '</p>' . "\n" . $html;
}, 10, 5 );
