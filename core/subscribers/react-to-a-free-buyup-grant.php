<?php
// React to a free buy-up grant, separately from a purchase

// Somebody bought it: thank them, and count the money.
add_action( 'benecaster_buyup_purchased', function ( $user_id, $buyup_id, $show_id ) {
    my_send_thanks_for_buying( $user_id, $buyup_id );
    my_record_buyup_revenue( $buyup_id, $show_id );
}, 10, 3 );

// Somebody was GIVEN it because their billing period includes it, or added
// a free one back from their account page. No money moved — so a "thanks for
// your purchase" email here would be wrong, and a revenue line would be a
// false number.
add_action( 'benecaster_buyup_auto_granted', function ( $user_id, $buyup_id, $show_id ) {
    my_send_included_with_your_plan_note( $user_id, $buyup_id );
}, 10, 3 );

// Fulfilment that both should reach — register the same callback on both,
// rather than assuming the purchase hook covers everyone who holds it.
add_action( 'benecaster_buyup_purchased',     'my_provision_buyup_access', 10, 3 );
add_action( 'benecaster_buyup_auto_granted',  'my_provision_buyup_access', 10, 3 );
