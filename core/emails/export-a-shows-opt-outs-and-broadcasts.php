<?php
// Add a show's email opt-outs and broadcast history to the data export

add_filter( 'benecaster_export_sheet_rows_my_opt_outs', function ( array $rows, array $context ): array {
    foreach ( benecaster_get_email_opt_outs( (int) $context['show_id'] ) as $opt_out ) {
        $rows[] = [ $opt_out['email'], $opt_out['scope'], $opt_out['opted_out_at'] ];
    }
    return $rows;
}, 10, 2 );

add_filter( 'benecaster_export_sheet_rows_my_broadcasts', function ( array $rows, array $context ): array {
    $broadcasts = benecaster_get_broadcasts( (int) $context['show_id'], [
        'date_from' => $context['date_start'],
        'date_to'   => $context['date_end'],
    ] );
    foreach ( $broadcasts as $broadcast ) {
        $rows[] = [ $broadcast['subject'], $broadcast['created_at'], $broadcast['recipients'], $broadcast['status'] ];
    }
    return $rows;
}, 10, 2 );
