<?php
// Set a different transcription language for one episode

add_filter( 'benecaster_transcription_language', function ( string $language, int $show_id, int $episode_id ): string {
    // One interview recorded in Spanish on an English show. 'es' is the same code on all
    // four built-in providers; a regional code is not (AssemblyAI 'en_uk', Deepgram 'es-419', Rev.ai 'en-gb').
    return 456 === $episode_id ? 'es' : $language;
}, 10, 3 );
