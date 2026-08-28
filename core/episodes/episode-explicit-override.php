<?php
// Resolve or override an episode's Explicit flag

use Benecaster\Episode\EpisodeMeta;
use Benecaster\Show\ShowMeta;

// Read the effective flag exactly as the RSS compiler does.
$ep_meta     = new EpisodeMeta( $episode_id );
$show_meta   = new ShowMeta( wp_get_post_parent_id( $episode_id ) );
$is_explicit = $ep_meta->get_effective_explicit( $show_meta ); // bool

// Write a per-episode override — never pass a raw bool.
$ep_meta->set_explicit( 'no' );      // force clean regardless of show default
$ep_meta->set_explicit( 'yes' );     // force explicit
$ep_meta->set_explicit( 'inherit' ); // clear the override
