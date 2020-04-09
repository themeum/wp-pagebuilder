<?php
/*
 * Plugin Name:       WP Page Builder
 * Plugin URI:        https://www.themeum.com/product/wp-pagebuilder/
 * Description:       WP Page Builder is a FREE drag & drop website building tool for WordPress. This plugin lets you develop a wonderful site in minutes without any coding.
 * Version:           1.2.3
 * Author:            Themeum.com
 * Author URI:        https://themeum.com
 * Text Domain:       wp-pagebuilder
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// Language Load
add_action( 'init', 'wppb_builder_language_load');
function wppb_builder_language_load(){
    $plugin_dir = basename(dirname(__FILE__))."/languages/";
    load_plugin_textdomain( 'wp-pagebuilder', false, $plugin_dir );
}

// Define Version
define('WPPB_VERSION', '1.2.3');

// Define License
define('WPPB_LICENSE', 'free');

// Define Dir URL
define('WPPB_DIR_URL', plugin_dir_url(__FILE__));

// Define Physical Path
define('WPPB_DIR_PATH', plugin_dir_path(__FILE__));

//WP PageBuilder Base Name
define('WPPB_BASENAME', plugin_basename(__FILE__));

// Include Require File
require_once WPPB_DIR_PATH.'core/initial-setup.php'; // Initial Setup Data

// Version Check & Include Core
if ( ! version_compare( PHP_VERSION, '5.4', '>=' ) ) {
    add_action('admin_notices', array('WPPB_Initial_Setup', 'php_error_notice')); // PHP Version Check
} elseif ( ! version_compare( get_bloginfo( 'version' ), '4.5', '>=' ) ) {
    add_action('admin_notices', array('WPPB_Initial_Setup', 'worpress_error_notice')); // WordPress Version Check
} else {
    require_once WPPB_DIR_PATH.'inc/WPPB.php';              // Loading Page Builder Main Files
}

// Initialize Data When plugins Activated
function wppb_builder_activate() {
    WPPB_Initial_Setup::initialize_data();
}
register_activation_hook( __FILE__, 'wppb_builder_activate' );

add_action( 'upgrader_process_complete', 'wppb_upgrade_completed', 10, 2 );
function wppb_upgrade_completed( $upgrader_object, $options ) {
    $our_plugin = plugin_basename( __FILE__ );
    if( $options['action'] == 'update' && $options['type'] == 'plugin' && isset( $options['plugins'] ) ) {
        foreach( $options['plugins'] as $plugin ) {
            if( $plugin == $our_plugin ) {
                WPPB_Initial_Setup::wppb_legacy_data();
            }
        }
    }
}
