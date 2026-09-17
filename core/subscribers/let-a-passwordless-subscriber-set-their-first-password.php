<?php
// Let a passwordless subscriber set their first password

// Provisioning an account nobody is present to choose a password for.
$user_id = wp_create_user( $login, wp_generate_password( 32, true, true ), $email );

if ( ! is_wp_error( $user_id ) ) {
    \Benecaster\Support\GeneratedPasswordMarker::mark( (int) $user_id );
}

// Anywhere you render your own "change password" form: drop the
// "current password" field for people who have never had one.
if ( \Benecaster\Support\GeneratedPasswordMarker::is_generated( $user_id ) ) {
    // ask only for the new password
}
