<?php
// Name your own backup plugin on the migration wizard's first step

add_filter( 'benecaster_migration_backup_plugins', function ( array $plugins ): array {
    // Detect by a symbol the plugin defines, not by an entry in
    // `active_plugins`: this runs on `admin_enqueue_scripts`, when every
    // active plugin has already loaded, and the option is a list of file
    // paths that is wrong for a network-activated plugin anyway.
    if ( ! class_exists( 'My_Backup_Plugin' ) ) {
        return $plugins;
    }

    $plugins[] = [
        'slug'        => 'my-backup-plugin',
        // Not translated: a plugin's own proper noun. A translated name
        // stops the podcaster recognising it in their own menu.
        'name'        => 'My Backup Plugin',
        // null is a correct answer. The wizard then names the plugin
        // without a link, which is better than linking somewhere wrong.
        'settingsUrl' => admin_url( 'admin.php?page=my-backup-plugin' ),
    ];

    return $plugins;
} );
