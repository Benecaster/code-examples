<?php
// Read a show's email opens and clicks

if ( function_exists( 'benecaster_email_editor_get_engagement' ) ) {
    $sends = benecaster_email_editor_get_engagement( $show_id, [
        'type'    => 'episode_notification',
        'since'   => gmdate( 'Y-m-d H:i:s', strtotime( '-90 days' ) ),
        'by_tier' => true,
    ] );

    if ( null === $sends ) {
        // Email Editor is not on for this show: show a placeholder instead.
    } else {
        foreach ( $sends as $send ) {
            $rate = $send['recipients'] > 0 ? $send['opened'] / $send['recipients'] : 0.0;
            // $send['by_tier']['gold']['opened'] …
        }
    }
}
