<?php
// List a show's failed emails

function my_addon_failed_emails( int $show_id, int $page = 1 ): array {
    if ( ! current_user_can( 'manage_options' ) ) {
        return [ 'rows' => [], 'total' => 0 ];
    }

    $filters = [
        'show_id'   => $show_id,
        'date_from' => gmdate( 'Y-m-01' ), // UTC, from the start of the month
    ];

    $rows = array_filter(
        benecaster_get_email_log( $filters + [ 'limit' => 100, 'offset' => ( $page - 1 ) * 100 ] ),
        static fn( array $row ): bool => 'failed' === $row['status']
    );

    return [ 'rows' => array_values( $rows ), 'total' => benecaster_count_email_log( $filters ) ];
}
