<?php
// Choose the model, or start a run, for Format transcript

add_filter( 'benecaster_html_formatting_model', function ( string $model, int $episode_id ): string {
    return 12 === (int) get_post_field( 'post_parent', $episode_id ) ? 'gpt-4.1-mini' : $model;
}, 10, 2 );
