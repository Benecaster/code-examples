<?php
// React when a migration brings transcripts across

add_action( 'benecaster_migration_transcript_imported', function (
    int $episode_id,
    int $transcript_id,
    string $format,
    string $source_url
): void {
    // $format is the feed tag's own type: "text/vtt", not "vtt".
    error_log( sprintf( 'Migrated transcript for episode %d from %s', $episode_id, $source_url ) );
}, 10, 4 );
