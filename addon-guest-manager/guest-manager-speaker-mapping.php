<?php
// Map transcript speakers to guests, as Transcription's speaker mapping does

// Where a transcript is drawn: one speaker's label.
// $mapping = [ 2 => [ 'guest_id' => 42, 'name' => 'Alice Smith' ], 1 => [ 'guest_id' => 0, 'name' => 'Pat (host)' ] ].
function my_addon_speaker_label( int $speaker, array $mapping, int $episode_id ): string {
    $mapped = $mapping[ $speaker ] ?? null;
    if ( null === $mapped ) {
        /* translators: %d: speaker number. */
        return sprintf( __( 'Speaker %d', 'my-addon' ), $speaker );
    }

    $show_id = (int) get_post_field( 'post_parent', $episode_id );
    $live    = $mapped['guest_id'] > 0
        && function_exists( 'benecaster_guest_manager_get_guest' )
        && benecaster_addon_is_active( 'benecaster-addon-guest-manager', $show_id )
        ? benecaster_guest_manager_get_guest( (int) $mapped['guest_id'] )
        : null;

    return null !== $live ? $live['name'] : (string) $mapped['name'];
}

// A rename or deletion on the Guests screen: drop rendered transcripts that name the guest.
add_action( 'benecaster_guest_manager_after_save_guest', 'my_addon_forget_guest_renders' );
add_action( 'benecaster_guest_manager_after_delete_guest', 'my_addon_forget_guest_renders' );
