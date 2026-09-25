<?php
// Deliver a downloadable extra to the people who bought your buy-up

// Put colouring-book buyers on a mailing list when they open the "crafts" page.
add_action( 'template_redirect', function (): void {
    if ( ! is_page( 'crafts' ) || ! is_user_logged_in() ) {
        return;
    }

    $user_id = get_current_user_id();
    $show_id = 3;  // The show that sells the buy-up.

    // The "Colouring Book" buy-up's row ID in benecaster_buyups.
    // A buy-up lasts only as long as the membership it rides on.
    $colouring_book_buyup_id = 12;

    if ( benecaster_user_has_buyup( $user_id, $colouring_book_buyup_id, $show_id ) ) {
        my_crm_subscribe( $user_id, 'crafts' ); // Your mailing-list integration.
    }

    // A one-off purchase is owned outright and survives the end of the membership.
    if ( benecaster_user_holds_grant( $show_id, 'season-one', $user_id ) ) {
        my_crm_subscribe( $user_id, 'season-one-buyers' );
    }
} );
