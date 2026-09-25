<?php
// React to a scheduled plan change, and to the change itself

// They ASKED. Nothing has been charged and their access has not moved.
add_action(
    'benecaster_subscription_tier_switch_scheduled',
    function ( $user_id, $show_id, $from_tier_slug, $to_tier_slug, $switch_at ) {
        // Use $to_tier_slug: looking their tier up here returns $from_tier_slug.
        my_note_intent( $user_id, $to_tier_slug, $switch_at );
    },
    10,
    5
);

// They WITHDREW it before it landed (or their membership was cancelled).
add_action(
    'benecaster_subscription_cadence_switch_cancelled',
    function ( $user_id, $show_id, $to_price_id, $reason ) {
        my_clear_intent( $user_id, $show_id );
    },
    10,
    4
);

// It HAPPENED. Their tier, their feed and their badges have moved.
add_action(
    'benecaster_subscription_tier_changed',
    function ( $user_id, $show_id, $old_tier_slug, $new_tier_slug ) {
        my_clear_intent( $user_id, $show_id );
        my_provision_tier_perks( $user_id, $new_tier_slug );
    },
    10,
    4
);
