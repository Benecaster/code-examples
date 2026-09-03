<?php
// Clear spam and abuse from the Supporter Wall automatically

add_action( 'benecaster_subscriber_wall_message', function ( int $user_id, string $message ): void {
    // The hook fires on clears too. Nothing to screen, so stop here.
    if ( '' === trim( $message ) ) {
        return;
    }

    // 1. Word list. Deliberately empty - add your own terms, lowercase.
    //    e.g. [ 'exampleterm', 'anotherterm' ]
    $words = [];

    $haystack = mb_strtolower( $message );
    foreach ( $words as $word ) {
        if ( str_contains( $haystack, $word ) ) {
            my_clear_wall_message( $user_id, $message, 'wordlist' );
            return;
        }
    }

    // 2. Predominantly non-Latin script. Tune the threshold to your audience,
    //    or drop this check entirely if your listeners write in these scripts.
    $cyrillic = preg_match_all( '/\p{Cyrillic}/u', $message );
    $cjk      = preg_match_all( '/\p{Han}|\p{Hiragana}|\p{Katakana}/u', $message );
    $letters  = max( 1, preg_match_all( '/\p{L}/u', $message ) );

    if ( ( $cyrillic + $cjk ) / $letters > 0.5 ) {
        my_clear_wall_message( $user_id, $message, 'script' );
        return;
    }

    // 3. Any URL at all. Honest messages rarely contain one.
    if ( preg_match( '#https?://|www\.|\b[a-z0-9-]+\.(com|net|ru|cn|xyz|top)\b#i', $message ) ) {
        my_clear_wall_message( $user_id, $message, 'link' );
    }
}, 10, 2 );

/**
 * Blank the live message, but keep the original so a false positive is
 * recoverable and reviewable. The direct write does not re-enter the hook.
 */
function my_clear_wall_message( int $user_id, string $original, string $reason ): void {
    update_user_meta( $user_id, '_benecaster_subscriber_wall_message', '' );
    update_user_meta( $user_id, '_my_wall_message_cleared', [
        'original' => $original,
        'reason'   => $reason,
        'at'       => current_time( 'mysql' ),
    ] );
}
