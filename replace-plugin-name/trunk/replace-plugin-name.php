<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the
 * plugin Dashboard. This file also includes all of the dependencies used by
 * the plugin, registers the activation and deactivation functions, and defines
 * a function that starts the plugin.
 *
 * @link replace_plugin_url
 * @since 1.0.0
 *
 * @package Replace_Package_Name
 *
 * @wordpress-plugin
 * Plugin Name:  Replace Plugin Nicename
 * Plugin URI:   replace_plugin_url
 * Description:  Replace plugin description.
 * Version:      1.0.0
 * Author:       Replace Author Name
 * Author URI:   replace_author_url
 * License:      GPL-2.0+
 * License URI:  http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:  replace-plugin-text-domain
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
 * @see Replace_Plugin_Name_Activator
 */
function activate_replace_plugin_name() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-replace-plugin-name-activator.php';
	Replace_Plugin_Name_Activator::activate();
}
register_activation_hook( __FILE__, 'activate_replace_plugin_name' );

/**
 * The code that runs during plugin deactivation.
 *
 * @since 1.0.0
 *
 * @see Replace_Plugin_Name_Deactivator
 */
function deactivate_replace_plugin_name() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-replace-plugin-name-deactivator.php';
	Replace_Plugin_Name_Deactivator::deactivate();
}
register_deactivation_hook( __FILE__, 'deactivate_replace_plugin_name' );

/**
 * The core plugin class that is used to define internationalization, dashboard-
 * specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-replace-plugin-name.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks, then kicking off
 * the plugin from this point in the file does not affect the page life cycle.
 *
 * @since 1.0.0
 *
 * @see Replace_Plugin_Name
 */
function run_replace_plugin_name() {

	$plugin = Replace_Plugin_Name::get_instance();
	$plugin->run();

}
run_replace_plugin_name();
