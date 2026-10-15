<?php
// Chart Listener Support donations beside membership revenue

function my_monthly_donations( int $show_id ): array {
    $rows   = benecaster_get_listener_support_donations( $show_id, [
        'date_from' => gmdate( 'Y-m-01', strtotime( '-11 months' ) ),
    ] );
    $totals = [];
    $counts = [];
    foreach ( $rows as $row ) {
        $month = substr( $row['donated_at'], 0, 7 );   // UTC month
        $counts[ $month ] = ( $counts[ $month ] ?? 0 ) + 1;
        if ( null === $row['amount_donated'] ) {
            continue;                                   // a donation with no amount: counted, never summed as zero
        }
        $currency = $row['currency'];                   // never sum across currencies
        $totals[ $currency ][ $month ] = ( $totals[ $currency ][ $month ] ?? 0 ) + $row['amount_donated']; // minor units
    }
    return [ 'by_currency' => $totals, 'donations_per_month' => $counts ];
}
