<?php
// Change how many earlier versions of an email design are kept

add_filter( 'benecaster_email_editor_template_versions_kept', function ( int $keep, string $type, int $show_id ): int {
    // Keep more of the email you change most, and less of everything else.
    return 'welcome' === $type ? 50 : 10;
}, 10, 3 );
