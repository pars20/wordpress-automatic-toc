<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class Asset_Manager {

    /**
     * Registers and enqueues the plugin's CSS and JavaScript files.
     */
    public function enqueue_assets() {
        $plugin_version = '2.0.0'; // Define version for cache busting

        wp_enqueue_style(
            'mindmade-toc-style',
            plugins_url('../assets/css/mindmade_toc.css', __FILE__),
            [],
            $plugin_version
        );

        wp_enqueue_script(
            'mindmade-toc-script',
            plugins_url('../assets/js/mindmade_toc.js', __FILE__),
            ['jquery'],
            $plugin_version,
            true // Load in footer
        );
    }
}
