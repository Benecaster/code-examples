<?php
// Change the wrapper around a podcaster's emails, or react when their branding is saved

add_filter( 'benecaster_email_editor_wrapper_html', function ( string $html, array $branding, int $show_id ): string {
    // Leave {{tags}} for core: it substitutes and escapes them at send time.
    return str_replace( '{{body}}', '{{body}}<p>Thanks for listening to {{show_title}}.</p>', $html );
}, 10, 3 );

add_action( 'benecaster_email_editor_after_branding_save', function ( int $show_id, array $branding ): void {
    update_option( 'my_addon_email_accent_' . $show_id, $branding['accent_color'] );
}, 10, 2 );
