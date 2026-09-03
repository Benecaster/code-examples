<?php
// Stop showing a Benecaster price after it changes

add_action( 'benecaster_pricing_data_changed', function ( array $pricing, ?string $previous, string $next ): void {
    // Force a rebuild of any cached plan-comparison snapshot when prices move.
    delete_transient( 'my_plan_comparison_html' );
}, 10, 3 );
