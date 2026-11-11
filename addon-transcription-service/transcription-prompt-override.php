<?php
// Send a different vocabulary prompt for one episode

add_filter( 'benecaster_transcription_prompt', function ( string $prompt, int $show_id, int $episode_id ): string {
    // One episode's guest and the terms only they use, added after the show's prompt.
    return 456 === $episode_id ? $prompt . "\nMarguerite Duras, nouveau roman, Lol V. Stein" : $prompt;
}, 10, 3 );
