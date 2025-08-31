<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class MindMade_TOC_Plugin {

    /**
     * The TOC Generator instance.
     * @var TOC_Generator
     */
    private $toc_generator;

    /**
     * The Asset Manager instance.
     * @var Asset_Manager
     */
    private $asset_manager;

    /**
     * Constructor. Sets up the plugin.
     */
    public function __construct() {
        $this->toc_generator = new TOC_Generator();
        $this->asset_manager = new Asset_Manager();

        $this->add_hooks();
    }

    /**
     * Registers all the WordPress hooks.
     */
    private function add_hooks() {
        // Main filter to add the TOC to content
        add_filter('the_content', [$this, 'add_toc_to_content'], 9);

        // Hook for enqueuing styles and scripts
        add_action('wp_enqueue_scripts', [$this->asset_manager, 'enqueue_assets']);

        // Hooks for plugin activation and deactivation
        register_activation_hook( __FILE__, [$this, 'activate'] );
        register_deactivation_hook( __FILE__, [$this, 'deactivate'] );
    }

    /**
     * Callback for 'the_content' filter.
     * Delegates the heavy lifting to the TOC_Generator class.
     *
     * @param string $content The post content.
     * @return string The modified post content.
     */
    public function add_toc_to_content($content) {
        // We only want to add a TOC to single posts.
        if (is_singular() && in_the_loop() && is_main_query()) {
            return $this->toc_generator->generate($content);
        }
        return $content;
    }
    
    /**
     * Plugin activation callback.
     */
    public function activate() {
        add_option('mindmade_toc_auto_version', '2.0.0');
    }

    /**
     * Plugin deactivation callback.
     */
    public function deactivate() {
        delete_option('mindmade_toc_auto_version');
    }
}