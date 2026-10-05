<?php
// Keep your own record of who you have chased

// Log every chase against the show, for a weekly digest.
add_action( 'benecaster_migration_invite_resent', function ( int $patron_id, int $import_id, int $show_id ): void {
    $log   = get_post_meta( $show_id, 'my_migration_chases', true );
    $log   = is_array( $log ) ? $log : [];
    $log[] = [
        'patron_id' => $patron_id,
        'import_id' => $import_id,
        'by'        => get_current_user_id(),
        'at'        => gmdate( 'Y-m-d H:i:s' ),
    ];

    update_post_meta( $show_id, 'my_migration_chases', $log );
}, 10, 3 );
