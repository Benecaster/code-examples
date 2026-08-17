<?php
// Redefine tenure badge milestones with custom thresholds and labels

// Quarterly recognition — thresholds at 3 / 6 / 9 / 12 / 24 months, with
// labels that read as anniversaries rather than "N-Month Member" progression.
add_filter( 'benecaster_tenure_badge_milestones', function ( array $default ): array {
	return [
		3  => 'First-Quarter Supporter',
		6  => 'Half-Year Supporter',
		9  => 'Three-Quarter Supporter',
		12 => 'One-Year Anniversary',
		24 => 'Two-Year Anniversary',
	];
} );

// Optional: fine-tune labels once picked. `benecaster_tenure_badge_label`
// fires AFTER the milestone match with the four args below — flag long-tenure
// supporters with a distinct label the milestone map alone can't express.
add_filter( 'benecaster_tenure_badge_label', function ( string $label, int $user_id, int $show_id, int $months_since_join ): string {
	// Beyond three years, override the milestone label with a
	// custom "Charter Member" designation regardless of what the
	// milestone matcher picked. The milestone map above tops out
	// at 24 months, so this branch kicks in for month 36 onwards.
	if ( $months_since_join >= 36 ) {
		return __( 'Charter Member', 'my-addon' );
	}
	return $label;
}, 10, 4 );
