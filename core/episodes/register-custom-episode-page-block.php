<?php
// Register a custom Episode Page block from an add-on

add_filter( 'benecaster_episode_page_block_types', function ( array $types ): array {
    $types['my_sponsors'] = [
        'label'    => __( 'Sponsors of this episode', 'my-addon' ),
        'default'  => true,
        'position' => 'after',
        'requires' => 'benecaster-addon-my-addon',
        'renderer' => static function ( int $episode_id, int $show_id, array $config ): string {
            $sponsors = my_addon_get_sponsors( $episode_id );
            if ( empty( $sponsors ) ) {
                return '';
            }
            $items = implode( '', array_map(
                static fn( $sponsor ) => '<li>' . esc_html( $sponsor->name ) . '</li>',
                $sponsors
            ) );
            return '<ul class="my-addon-sponsors">' . $items . '</ul>';
        },
        'settings' => static fn( array $config ): string => '', // not read; see the notes
    ];
    return $types;
} );
