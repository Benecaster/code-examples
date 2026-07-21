// Add a custom section to the analytics digest email
add_filter(
    'benecaster_analytics_digest_data',
    function ( array $data, string $type, int $show_id, array $period ): array {
        if ( ! benecaster_addon_is_active( 'listener-support' ) ) {
            return $data;
        }
        global $wpdb;
        $total = (float) $wpdb->get_var( $wpdb->prepare(
            "SELECT COALESCE( SUM( amount ), 0 )
               FROM {$wpdb->prefix}benecaster_listener_support_donations
              WHERE show_id = %d AND donated_at BETWEEN %s AND %s",
            $show_id,
            $period['start'],
            $period['end']
        ) );
        $data['listener_support_totals'] = [
            'amount'   => $total,
            'currency' => 'USD',
        ];
        return $data;
    },
    10,
    4
);

add_filter(
    'benecaster_analytics_digest_sections',
    function ( array $sections, string $type, int $show_id, array $data ): array {
        if ( ! benecaster_addon_is_active( 'listener-support' ) ) {
            return $sections;
        }
        $totals = $data['listener_support_totals'] ?? null;
        if ( ! is_array( $totals ) || ( (float) $totals['amount'] ) <= 0.0 ) {
            return $sections; // Skip the section when there is nothing to report.
        }
        $sections[] = [
            'id'       => 'listener_support_totals',
            'title'    => esc_html__( 'Listener support', 'benecaster' ),
            'data'     => $totals,
            'template' => plugin_dir_path( __FILE__ ) . 'templates/digest-listener-support.php',
        ];
        return $sections;
    },
    10,
    4
);
