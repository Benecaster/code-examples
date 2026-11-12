<?php
// List the account emails that belong to no show

function my_addon_account_emails( int $page = 1 ): array {
    if ( ! current_user_can( 'manage_options' ) ) {
        return [ 'rows' => [], 'total' => 0 ];
    }

    $filters = [ 'show_id' => 0 ]; // 0 = no show. Leave show_id out to mean every show.

    return [
        'rows'  => benecaster_get_email_log( $filters + [ 'limit' => 50, 'offset' => ( $page - 1 ) * 50 ] ),
        'total' => benecaster_count_email_log( $filters ),
    ];
}
