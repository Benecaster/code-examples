<?php
// Load a custom template part from an add-on

// In your add-on's shortcode or block renderer:
// Option 1 — use the global function (checks child theme → parent theme → plugin default).
echo benecaster_get_template_part( 'my-addon/player-widget', [ 'episode' => $episode ], false );

// Option 2 — use TemplateLoader directly for add-on-specific templates.
// This lets you set a custom plugin_templates_dir pointing to your add-on's templates/.
$loader = new \Benecaster\Template\TemplateLoader(
    plugin_dir_path( __FILE__ ) . 'templates'
);
echo $loader->load( 'player-widget', [ 'episode' => $episode ], false );
// Theme devs override at: [theme]/benecaster/my-addon/player-widget.php
