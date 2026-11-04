<?php
// Read what the podcaster chose for an episode's notification

$kept   = get_post_meta( $episode_id, '_benecaster_email_editor_compose', true );
$choice = is_array( $kept ) ? ( $kept['choice'] ?? 'template' ) : 'template';

$label = [
    'template' => __( 'Using the notification template', 'my-addon' ),
    'custom'   => __( 'Composed for this episode', 'my-addon' ),
    'none'     => __( 'No notification', 'my-addon' ),
][ $choice ] ?? '';
