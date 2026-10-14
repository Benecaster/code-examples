<?php
// Chart built-in membership revenue from what was actually charged

function my_monthly_membership_revenue( int $show_id ): array {
    $rows   = benecaster_get_membership_payments( $show_id, [
        'date_from' => gmdate( 'Y-m-01', strtotime( '-11 months' ) ),
    ] );
    $months = [];
    foreach ( $rows as $row ) {
        $month    = substr( $row['paid_at'], 0, 7 );          // UTC month
        $currency = $row['currency'];                        // never sum across currencies
        $net      = $row['amount_paid'] - $row['amount_tax'] - $row['amount_refunded'];
        $months[ $currency ][ $month ] = ( $months[ $currency ][ $month ] ?? 0 ) + $net; // minor units
    }
    return [
        'by_currency'    => $months,
        'recorded_since' => benecaster_get_membership_payments_recorded_since(), // say so on the chart
    ];
}
