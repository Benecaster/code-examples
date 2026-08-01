<?php
// Confirm subscriber app setup and fire a first-listen celebration

add_action(
    'benecaster_token_first_accessed',
    function ( int $user_id, int $show_id, string $tier_slug ): void {
        $user = get_userdata( $user_id );
        if ( ! $user ) {
            return;
        }
        // Remove subscriber from "needs setup" nurture sequence.
        my_esp_remove_tag( $user->user_email, 'podcast-setup-pending' );
        // Trigger "you're all set!" celebration email or CRM event.
        my_crm_event( $user->user_email, 'podcast_app_configured', [
            'show_id'   => $show_id,
            'tier_slug' => $tier_slug,
        ] );
    },
    10,
    3
);
