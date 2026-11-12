<?php
// Follow the show's language, with your own default when the podcaster has not set one

function my_addon_language_for( int $show_id ): string {
    $chosen = benecaster_get_show_language( $show_id, true ); // '' when Not set

    return '' !== $chosen ? $chosen : 'auto'; // your own default, e.g. auto-detect
}
