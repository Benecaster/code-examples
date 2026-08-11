<?php
// Override the mailing-list opt-in checkbox label on the donation form

add_filter(
    'benecaster_donor_enrollment_label',
    function ( string $default_label, int $show_id, string $show_title ): string {
        return sprintf(
            /* translators: %s: podcast show title */
            __( 'Yes! Send me updates from %s (~1 email per month, unsubscribe anytime).', 'my-addon' ),
            $show_title
        );
    },
    10,
    3
);
