<?php
// React when a podcaster saves an email design

add_filter( 'benecaster_email_editor_template_html', function ( string $html, array $design, string $type, int $show_id ): string {
    // Leave {{tags}} for core: it substitutes and escapes them at send time.
    return 'welcome' === $type ? $html . '<p>{{show_title}} is made with love.</p>' : $html;
}, 10, 4 );

add_action( 'benecaster_email_editor_after_template_save', function ( int $show_id, string $type, array $design ): void {
    delete_transient( 'my_addon_design_summary_' . $show_id );
}, 10, 3 );
