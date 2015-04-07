<?php

/**
 * Fired during plugin activation
 *
 * @since 1.0.0
 *
 * @package YuMag_Plugin
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since 1.0.0
 */
class YuMag_Plugin_Activator {

	/**
	 * Run on plugin activation.
	 *
	 * Carries out all one-time setup changes (especially to the database).
	 *
	 * @since 1.0.0
	 */
	public static function activate() {

		self::set_rewrite_rules();

	}

	/**
	 * Flush rewrite rules on plugin activation.
	 *
	 * Setup permalinks for all declared custom post types and taxonomies, by
	 * loading in the new types/taxonomies and then flushing rewrite rules.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected static function set_rewrite_rules() {

		/*
		 * Load the class that creates custom post types and taxonomies, so
		 * their URL rules can be applied using flush_rewrite_rules.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-yumag-plugin-notices.php';
		YuMag_Plugin_Notices::register_notices_post_type();
		YuMag_Plugin_Notices::register_notices_taxonomy();

		flush_rewrite_rules();

	}

}
