<?php
// Hide the sort controls on the episode archive

add_filter( 'benecaster_archive_show_filters', '__return_false' );
