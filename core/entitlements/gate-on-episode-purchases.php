<?php
// Gate anything on a listener's episode purchases

// One named product or bundle — the direct form, and the one to use in a gate.
if ( benecaster_user_holds_grant( get_the_ID(), 'season-one' ) ) {
    get_template_part( 'parts/season-one-extras' );
}

// Everything this listener owns on the show — live grants only.
foreach ( benecaster_get_user_grants( $show_id, $user_id ) as $slug ) {
    echo esc_html( $slug );   // your own product names live in your add-on
}
