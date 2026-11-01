<?php
// React when a podcaster resets an email design or their branding

add_action( 'benecaster_email_editor_after_template_reset', function ( int $show_id, string $type ): void {
    delete_transient( 'my_addon_design_summary_' . $show_id );
}, 10, 2 );
