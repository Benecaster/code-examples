<?php
// Flag imported episodes your own way

add_action( 'benecaster_boot', function ( \Benecaster\Container $container ): void {
    $rows = $container->make( \Benecaster\Episode\ImportReviewQuery::class )
        ->rows_for_show( $show_id );

    foreach ( $rows as $row ) {
        // $row['source'] is 'rss', 'ssp' or 'powerpress'.
        // Every optional field is '' when unset, never absent.
        if ( '' === $row['audio_url'] ) {
            error_log( "No audio: {$row['title']} ({$row['edit_url']})" );
        }
    }
} );
