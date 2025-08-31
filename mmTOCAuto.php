<?php
/**
 * Plugin Name:       MindMade TOC Auto
 * Plugin URI:        https://matisweb.com
 * Description:       SEO-friendly, fast-loading, automatic Table of Contents generator.
 * Version:           2.0.0
 * Author:            Jafar Naghizadeh
 * Author URI:        https://matisweb.com
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Requires PHP:      7.4
 * Requires at least: 5.0
 * Text Domain:       mindmade-toc-auto
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Include the class files
require_once plugin_dir_path( __FILE__ ) . 'includes/class-toc-generator.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-asset-manager.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-plugin-main.php';

// Instantiate the main plugin class to get everything started.
new MindMade_TOC_Plugin();
