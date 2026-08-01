<?php
// Register a fully custom XML namespace handler from an add-on

// In your add-on's boot class:
add_filter( 'benecaster_feed_namespaces', function ( array $handlers ): array {
    $handlers[] = new \MyAddon\MyCustomNamespace();
    return $handlers;
} );

// MyCustomNamespace implements FeedNamespaceInterface:
class MyCustomNamespace implements \Benecaster\Feed\Namespaces\FeedNamespaceInterface {
    public function get_xmlns(): array {
        return [ 'mycustom' => 'https://myaddon.example.com/ns/1.0' ];
    }

    public function channel_tags( int $show_id ): array {
        $value = get_post_meta( $show_id, '_my_addon_channel_tag', true );
        return $value ? [ '<mycustom:channel-tag>' . esc_xml( $value ) . '</mycustom:channel-tag>' . "\n" ] : [];
    }

    public function episode_tags( int $episode_id, int $show_id ): array {
        $value = get_post_meta( $episode_id, '_my_addon_episode_tag', true );
        return $value ? [ '<mycustom:episode-tag>' . esc_xml( $value ) . '</mycustom:episode-tag>' . "\n" ] : [];
    }
}
