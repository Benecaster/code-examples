// React when an episode gains a transcript

<?php
add_action(
    'benecaster_transcript_url_generated',
    function ( int $episode_id, string $url, string $mime_type ): void {
        // Cheap: hand the slow part to cron rather than holding up the save.
        wp_schedule_single_event(
            time() + 30,
            'my_addon_process_transcript',
            [ $episode_id, $url, $mime_type ]
        );
    },
    10,
    3
);
