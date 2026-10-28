<?php
// Send a different vocabulary prompt for one show or episode

add_filter( 'benecaster_transcription_prompt', function ( string $prompt, int $show_id, int $episode_id ): string {
    // A cooking show: its own terms, added to the global prompt.
    return 123 === $show_id ? $prompt . ', sous vide, mirepoix, Escoffier' : $prompt;
}, 10, 3 );
