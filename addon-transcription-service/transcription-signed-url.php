<?php
// Give eligible listeners a signed, expiring transcript address instead of the permanent one

// 1. Swap the address. Priority 10 or later: Transcription Service filters at 5 and has
//    already removed the entry for every listener its setting excludes.
add_filter( 'benecaster_feed_podcast_episode_tags', function ( array $tags ): array {
    if ( isset( $tags['transcript']['url'] ) ) {
        $tags['transcript'] = [ $tags['transcript'] ]; // Benecaster seeds ONE entry, not a list.
    }
    foreach ( $tags['transcript'] ?? [] as $i => $entry ) {
        if ( preg_match( '#/benecaster-transcription/v1/transcripts/([a-f0-9]{32})\.vtt#', (string) ( $entry['url'] ?? '' ), $m ) ) {
            $expires = ( intdiv( time(), DAY_IN_SECONDS ) + 8 ) * DAY_IN_SECONDS; // 7–8 days, stable across a day of cached compiles
            $sig     = hash_hmac( 'sha256', $m[1] . '|' . $expires, wp_salt( 'auth' ) );
            $tags['transcript'][ $i ]['url'] = add_query_arg( [ 'my_transcript' => $m[1], 'exp' => $expires, 'sig' => $sig ], home_url( '/' ) );
        }
    }
    return $tags;
}, 10 );

// 2. Serve the signed address. Read the file through the add-on's own route, internally:
//    never redirect to the permanent address, which would hand it out again.
add_action( 'template_redirect', function (): void {
    $key = (string) ( $_GET['my_transcript'] ?? '' );
    if ( 1 !== preg_match( '/^[a-f0-9]{32}$/', $key ) ) {
        return;
    }
    $exp = (int) ( $_GET['exp'] ?? 0 );
    $sig = (string) ( $_GET['sig'] ?? '' );
    if ( $exp < time() || ! hash_equals( hash_hmac( 'sha256', $key . '|' . $exp, wp_salt( 'auth' ) ), $sig ) ) {
        status_header( 410 );
        exit;
    }
    $response = rest_do_request( new WP_REST_Request( 'GET', '/benecaster-transcription/v1/transcripts/' . $key . '.vtt' ) );
    if ( 200 !== $response->get_status() ) {
        status_header( 404 );
        exit;
    }
    header( 'Content-Type: text/vtt; charset=utf-8' );
    header( 'Access-Control-Allow-Origin: *' );
    header( 'X-Robots-Tag: noindex' );
    echo $response->get_data(); // The WebVTT body, already escaped by the add-on.
    exit;
} );

// 3. Optional: stop WordPress's own episode route giving the permanent address to non-editors.
add_filter( 'rest_prepare_benecaster_episode', function ( $response, $post ) {
    if ( $response instanceof WP_REST_Response && ! current_user_can( 'edit_post', $post->ID ) ) {
        $data = $response->get_data();
        unset( $data['meta']['_benecaster_podcast2_transcript_url'], $data['meta']['_benecaster_podcast2_transcript_type'] );
        $response->set_data( $data );
    }
    return $response;
}, 30, 2 );
