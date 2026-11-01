<?php
// Give your add-on's email a starting design in the Email Editor

add_filter( 'benecaster_email_editor_default_design', function ( ?array $design, string $type ): ?array {
    if ( 'my_addon_receipt' !== $type ) {
        return $design;
    }

    return [
        'blocks' => [
            [ 'id' => 'a', 'type' => 'heading', 'props' => [ 'text' => __( 'Thanks!', 'my-addon' ) ] ],
            [
                'id'         => 'b',
                'type'       => 'button',
                'props'      => [ 'label' => __( 'See your order', 'my-addon' ), 'url' => '{{order_url}}' ],
                // Core leaves a missing tag in the text as written, so a block with one tests it.
                'conditions' => [ [ 'type' => 'tag', 'tag' => 'order_url', 'when' => 'filled' ] ],
            ],
        ],
    ];
}, 10, 2 );
