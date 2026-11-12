<?php
// Put a tile on the Podcast Workflow Workbench, and say where it stands for each episode

add_filter( 'benecaster_workbench_tiles', function ( array $tiles, int $show_id ): array {
    return $tiles + [
        'chapter-markers' => [
            'label'      => __( 'Chapter markers', 'my-plugin' ),
            'stage'      => 'post-production',
            'priority'   => 40,
            'default_on' => false,
        ],
    ];
}, 10, 2 );

add_filter( 'benecaster_workbench_tile_state', function ( ?array $state, string $tile_id, int $episode_id, int $show_id ): ?array {
    if ( 'chapter-markers' !== $tile_id ) {
        return $state;
    }
    $count = count( my_plugin_chapters( $episode_id ) );
    return [
        'status'       => $count > 0 ? 'done' : 'not_started',
        /* translators: %d: number of chapters */
        'summary'      => sprintf( _n( '%d chapter', '%d chapters', $count, 'my-plugin' ), $count ),
        'count'        => $count,
        'action_url'   => '#/episodes/' . $episode_id . '?tab=chapters',
        'action_label' => __( 'Edit chapters', 'my-plugin' ),
    ];
}, 10, 4 );
