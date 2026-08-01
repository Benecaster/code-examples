<?php
// Append custom columns or short-circuit the write for download log rows

add_filter(
    'benecaster_download_log_entry',
    function ( array $data, int $episode_id, int $user_id ): array {
        // Tag the row with a request-scoped campaign attribute.
        $campaign = isset( $_GET['utm_campaign'] ) ? sanitize_key( wp_unslash( $_GET['utm_campaign'] ) ) : '';
        if ( '' !== $campaign ) {
            $data['campaign'] = $campaign;
        }
        return $data;
    },
    10,
    3
);
