<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @since 1.0.0
 *
 * @package YuMag_Plugin/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines two example hooks for how to enqueue the admin-specific stylesheet
 * and JavaScript.
 *
 * Uses the Singleton pattern.
 *
 * @since 1.0.0
 */
class YuMag_Plugin_Admin extends YuMag_Plugin_Singleton {

	/**
	 * Register all hooks for actions and filters in this class.
	 *
	 * Called on this class's construction by the parent class method
	 * `YuMag_Plugin_Singleton::__construct()`.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function define_hooks() {

		// Enqueue public-facing styles and scripts.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_styles' ) );

	}

	/**
	 * Register the stylesheets for the Dashboard.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be hooked to the
		 * `wp_enqueue_scripts` action by this class's `define_hooks()` method,
		 * which is called by the parent class's constructor.
		 */

		$plugin = YuMag_Plugin::get_instance();

		wp_enqueue_style(
			$plugin->get_plugin_name(),
			plugin_dir_url( __FILE__ ) . 'css/yumag-plugin-admin.css',
			array(),
			$plugin->get_version(),
			'all'
		);

	}

	/**
	 * Register the JavaScript for the dashboard.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be hooked to the
		 * `wp_enqueue_scripts` action by this class's `define_hooks()` method,
		 * which is called by the parent class's constructor.
		 */

		$plugin = YuMag_Plugin::get_instance();

		wp_enqueue_script(
			$plugin->get_plugin_name(),
			plugin_dir_url( __FILE__ ) . 'js/yumag-plugin-admin.js',
			array( 'jquery' ),
			$plugin->get_version(),
			false
		);

	}

}
