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
        $paid     = (int) $row['amount_paid'];
        // amount_refunded includes the tax, so a full refund nets 0: keep the share not refunded.
        $kept     = $paid > 0 ? ( $paid - $row['amount_refunded'] ) / $paid : 0;
        $net      = ( $paid - $row['amount_tax'] ) * $kept;
        $months[ $currency ][ $month ] = ( $months[ $currency ][ $month ] ?? 0 ) + $net; // minor units
    }
    return [
        'by_currency'    => $months,
        'recorded_since' => benecaster_get_membership_payments_recorded_since(), // say so on the chart
    ];
}
