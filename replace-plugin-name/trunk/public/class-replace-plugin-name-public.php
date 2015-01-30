<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @since 1.0.0
 *
 * @package Replace_Plugin_Name/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines two examples hooks for how to enqueue the public-facing stylesheet
 * and JavaScript.
 *
 * Uses the Singleton pattern.
 *
 * @since 1.0.0
 */
class Replace_Plugin_Name_Public extends Replace_Plugin_Name_Singleton {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Replace_Plugin_Name_Public_Loader as all of the hooks are
		 * defined in that particular class.
		 *
		 * The Replace_Plugin_Name_Public_Loader will then create the
		 * relationship between the defined hooks and the functions defined in
		 * this class.
		 */

		$plugin = Replace_Plugin_Name::get_instance();

		wp_enqueue_style(
			$plugin->get_plugin_name(),
			plugin_dir_url( __FILE__ ) . 'css/replace-plugin-name-public.css',
			array(),
			$plugin->get_version(),
			'all'
		);

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Replace_Plugin_Name_Public_Loader as all of the hooks are
		 * defined in that particular class.
		 *
		 * The Replace_Plugin_Name_Public_Loader will then create the
		 * relationship between the defined hooks and the functions defined in
		 * this class.
		 */

		$plugin = Replace_Plugin_Name::get_instance();

		wp_enqueue_script(
			$plugin->get_plugin_name(),
			plugin_dir_url( __FILE__ ) . 'js/replace-plugin-name-public.js',
			array( 'jquery' ),
			$plugin->get_version(),
			false
		);

	}

}
