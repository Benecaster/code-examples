<?php
// Read, create, change, archive or restore the site's sponsors and a show's sponsor campaigns from code, as the Sponsors screen does

// Copy each new campaign into a CRM the podcaster uses, with its show.
add_action( 'benecaster_sponsor_manager_after_save_campaign', function ( int $campaign_id, int $show_id, array $fields, bool $created ): void {
    if ( $created ) {
        my_crm_add_deal( $campaign_id, $show_id, $fields['name'], $fields['start_date'], $fields['end_date'] );
    }
}, 10, 4 );
