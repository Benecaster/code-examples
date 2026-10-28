<?php
// Set a different transcription language for one show or episode

add_filter( 'benecaster_transcription_language', function ( string $language, int $show_id, int $episode_id ): string {
    // An all-Spanish show. 'es' is the same code on all four built-in providers;
    // a regional code is not (AssemblyAI 'en_uk', Deepgram 'es-419', Rev.ai 'en-gb').
    return 123 === $show_id ? 'es' : $language;
}, 10, 3 );
