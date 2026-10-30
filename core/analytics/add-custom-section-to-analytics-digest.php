<?php
// Add a Custom Section to the Analytics Digest

add_filter( 'benecaster_analytics_digest_data_weekly', function ( array $data, int $show_id, array $period ): array {
    if ( ! benecaster_addon_is_active( 'benecaster-addon-analytics-dashboard', $show_id ) ) {
        return $data;
    }
    $data['my_addon_donations'] = benecaster_get_listener_support_donations(
        $show_id,
        [ 'date_from' => $period['start'], 'date_to' => $period['end'] ] // Inclusive UTC days, as the reader takes them.
    );
    return $data;
}, 10, 3 );

add_filter( 'benecaster_analytics_digest_sections_weekly', function ( array $sections, int $show_id, array $data ): array {
    $rows = $data['my_addon_donations'] ?? [];
    if ( [] === $rows ) {
        return $sections; // Nothing to say: add nothing, so a quiet week stays unsent.
    }
    $by_currency = [];
    foreach ( $rows as $row ) {
        if ( null !== $row['amount_donated'] && null !== $row['currency'] ) {
            $by_currency[ $row['currency'] ] = ( $by_currency[ $row['currency'] ] ?? 0 ) + (int) $row['amount_donated'];
        }
    }
    $lines = [ sprintf( _n( '%s donation this week.', '%s donations this week.', count( $rows ), 'my-addon' ), number_format_i18n( count( $rows ) ) ) ];
    foreach ( $by_currency as $currency => $minor ) {
        $lines[] = sprintf( '%s %s', $currency, number_format_i18n(
            \Benecaster\Membership\RevenueLedgerRepository::to_major_units( $minor, $currency ),
            \Benecaster\Membership\RevenueLedgerRepository::decimals_for( $currency )
        ) );
    }
    $sections[] = [ 'id' => 'my_addon_donations', 'title' => __( 'Listener support', 'my-addon' ), 'lines' => $lines ];
    return $sections;
}, 10, 3 );
