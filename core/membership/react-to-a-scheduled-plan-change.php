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

// They chose the FREE plan. Their paid subscription ends at $switch_at
// without charging again. Not a cancellation: they stay a member.
add_action(
    'benecaster_subscription_free_switch_scheduled',
    function ( $user_id, $show_id, $from_tier_slug, $to_tier_slug, $switch_at ) {
        // A win-back email sent here reaches somebody who is still a member.
        my_note_intent( $user_id, $to_tier_slug, $switch_at );
    },
    10,
    5
);

// The free move landed. benecaster_subscription_tier_changed has already
// fired above; this says why. Same feed URL.
add_action(
    'benecaster_subscription_free_switch_landed',
    function ( $user_id, $show_id, $from_tier_slug, $to_tier_slug ) {
        my_move_to_free_segment( $user_id, $from_tier_slug );
    },
    10,
    4
);

// A free member took out a paid plan through signup. No switch hook fires,
// and neither does benecaster_subscription_tier_changed.
add_action(
    'benecaster_subscription_activated',
    function ( $user_id, $show_id, $tier_slug, $source ) {
        my_provision_tier_perks( $user_id, $tier_slug );
    },
    10,
    4
);
