<?php
// Link into Benecaster's admin on the right show

$url = benecaster_get_admin_url( '/analytics', $show_id );
// …/wp-admin/admin.php?page=benecaster&show_id=12#/analytics
printf( '<a href="%s">%s</a>', esc_url( $url ), esc_html__( 'Manage digest preferences', 'my-addon' ) );
