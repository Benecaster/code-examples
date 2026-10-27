<?php
// Print an episode's Recorded on date in a theme template

$raw = get_post_meta( get_the_ID(), '_benecaster_recorded_date', true );
if ( preg_match( '/^\d{4}-\d{2}-\d{2}$/', (string) $raw ) ) {
    $day = DateTimeImmutable::createFromFormat( '!Y-m-d', $raw, new DateTimeZone( 'UTC' ) );
    printf(
        '<p class="recorded-on">%s</p>',
        esc_html( sprintf(
            /* translators: %s: the date the episode was recorded */
            __( 'Recorded %s', 'my-theme' ),
            date_i18n( get_option( 'date_format' ), $day->getTimestamp(), true )
        ) )
    );
}
