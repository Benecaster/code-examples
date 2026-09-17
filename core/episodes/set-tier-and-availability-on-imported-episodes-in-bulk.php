<?php
// Set tier and availability on imported episodes in bulk

add_action( 'benecaster_boot', function ( \Benecaster\Container $container ): void {
    $show_id = 12;

    $rows = $container->make( \Benecaster\Episode\ImportReviewQuery::class )
        ->rows_for_show( $show_id, [ 'rss' ] );

    $container->make( \Benecaster\Migration\SspImporter::class )->apply_bulk_defaults(
        $show_id,
        array_column( $rows, 'id' ),
        'gold',                 // a tier's internal slug, or 'all'
        '2027-01-15 08:00:00'   // site-local, or 'immediate'
    );
} );
