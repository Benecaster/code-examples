<?php
// Send your own design for one Benecaster email, per show

add_filter( 'benecaster_email_template_body', static function ( ?string $html, string $type, array $tags, ?int $show_id ): ?string {
    if ( 'welcome' !== $type ) {
        return $html;
    }
    // No show (address verification, donor-data erasure): gate on the add-on being on anywhere.
    $active = null === $show_id
        ? benecaster_addon_is_active_for_any_show( 'my-addon' )
        : benecaster_addon_is_active( 'my-addon', $show_id );
    if ( ! $active ) {
        return $html;
    }
    $stored = null === $show_id ? '' : (string) get_post_meta( $show_id, '_my_addon_welcome_html', true );

    // '' means "nothing stored": keep Benecaster's template (or the theme's override).
    return '' !== $stored ? $stored : $html;
}, 10, 4 );

// A tag your add-on adds must be declared too, or an editor cannot offer it —
// and say if it carries HTML, or it arrives in a stored body as escaped text.
add_filter( 'benecaster_email_merge_tag_catalog', static function ( array $catalog ): array {
    $catalog['host_signature'] = [
        'label'       => __( 'Host signature', 'my-addon' ),
        'description' => __( 'The host’s sign-off, with formatting.', 'my-addon' ),
        'types'       => [ 'welcome' ],
        'sample'      => '<em>— Sam</em>',
        'kind'        => 'html',
    ];
    return $catalog;
} );
