<?php
// Send subscribers to a custom resume page on the cancellation confirmation

add_filter(
	'benecaster_cancellation_confirmation_resume_url',
	function ( string $default_url, int $user_id, int $show_id, array $subscription ): string {
		// Deep-link to the billing-portal Subscription section on the account
		// page. The account template's inline JS can watch for #resume-{show}
		// and auto-scroll + focus the Resume button.
		return add_query_arg( 'show_id', $show_id, $default_url ) . '#resume-' . $show_id;
	},
	10, 4
);
