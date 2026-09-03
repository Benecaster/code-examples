<?php
// Render the active theme's header/footer from a Benecaster template override without deprecation on block themes

// wp-content/themes/my-theme/benecaster/show/single.php
benecaster_get_header();
do_action( 'benecaster_before_show_render', $show_id );
// ... your custom show markup ...
do_action( 'benecaster_after_show_render', $show_id );
benecaster_get_footer();
