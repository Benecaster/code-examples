<?php
// Enrich a CRM as subscribers migrate

// Queue a CRM update per migrated person. Note what this does NOT do:
// call the CRM inline. On a large import that would be thousands of
// blocking HTTP requests in one PHP process.
add_action(
    'benecaster_migration_subscriber_imported',
    static function ( int $user_id, int $show_id, string $platform, array $data ): void {
        wp_schedule_single_event(
            time(),
            'acme_push_migrated_supporter',
            [
                'user_id'   => $user_id,
                'show_id'   => $show_id,
                'platform'  => $platform,
                // Segment on the tier, not on token_type: a free source
                // tier can land on a free tier as a 'subscriber'.
                'tier'      => $data['mapped_tier_slug'],
                'type'      => $data['token_type'],
                'joined_at' => $data['source_joined_at'],  // may be null
                'deadline'  => $data['grace_period_ends_at'],
            ]
        );
    },
    10,
    4
);
