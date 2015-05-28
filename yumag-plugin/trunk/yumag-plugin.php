<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the
 * plugin Dashboard. This file also includes all of the dependencies used by
 * the plugin, registers the activation and deactivation functions, and defines
 * a function that starts the plugin.
 *
 * @link http://www.yumagazine.co.uk/
 * @since 1.0.0
 *
 * @package YuMag_Plugin
 *
 * @wordpress-plugin
 * Plugin Name:  Yu Magazine Plugin
 * Plugin URI:   http://www.yumagazine.co.uk/
 * Description:  **DO NOT REMOVE OR DEACTIVATE!** Contains custom features for Yu Magazine.
 * Version:      1.1.0
 * Author:       cJ barnes
 * Author URI:   http://www.cjbarnes.co.uk/
 * License:      GPL-2.0+
 * License URI:  http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:  yumag-plugin
 * Domain Path:  /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! function_exists( 'write_log' ) ) :
/**
 * Error logging function.
 *
 * Prettifies output of array and object contents as well as simpler variables.
 *
 * @since 1.0.0
 *
 * @param array|string|object $log The variable to output to the error log.
 */
function write_log( $log )  {
	if ( true === WP_DEBUG ) {
		if ( is_array( $log ) || is_object( $log ) ) {
			error_log( print_r( $log, true ) );
		} else {
			error_log( $log );
		}
	}
}
endif;

/**
 * The code that runs during plugin activation.
 *
 * @since 1.0.0
 *
 * @see YuMag_Plugin_Activator
 */
function activate_yumag_plugin() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-yumag-plugin-activator.php';
	YuMag_Plugin_Activator::activate();
}
register_activation_hook( __FILE__, 'activate_yumag_plugin' );

/**
 * The code that runs during plugin deactivation.
 *
 * @since 1.0.0
 *
 * @see YuMag_Plugin_Deactivator
 */
function deactivate_yumag_plugin() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-yumag-plugin-deactivator.php';
	YuMag_Plugin_Deactivator::deactivate();
}
register_deactivation_hook( __FILE__, 'deactivate_yumag_plugin' );

/**
 * The core plugin class that is used to define internationalization, dashboard-
 * specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-yumag-plugin.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks, then kicking off
 * the plugin from this point in the file does not affect the page life cycle.
 *
 * @since 1.0.0
 *
 * @see YuMag_Plugin
 */
function run_yumag_plugin() {

	YuMag_Plugin::get_instance();

}
run_yumag_plugin();
