<?php
// React when an anonymous donor exercises right-to-erasure

add_action( 'benecaster_donor_data_erased', function ( string $email, int $deleted ): void {
    if ( $deleted > 0 ) {
        my_crm_purge_contact( $email );
    }
}, 10, 2 );
