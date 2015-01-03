<?php

/**
 * The functionality of the plugin that's shared between dashboard and public
 *
 * @since 1.0.0
 *
 * @package Replace_Plugin_Name
 */

/**
 * The functionality of the plugin that's shared between dashboard and public
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue a stylesheet and JavaScript.
 *
 * @since 1.0.0
 */
class Replace_Plugin_Name_Common {

	/**
	 * The ID of this plugin.
	 *
	 * @since 1.0.0
	 * @access private
	 * @var string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since 1.0.0
	 * @access private
	 * @var string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 1.0.0
	 *
	 * @var string $plugin_name The name of this plugin.
	 * @var string $version     The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the JavaScript shared between the dashboard and the public side
	 * of the site.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Replace_Plugin_Name_Common_Loader as all of the hooks are
		 * defined in that particular class.
		 *
		 * The Replace_Plugin_Name_Common_Loader will then create the
		 * relationship between the defined hooks and the functions defined in
		 * this class.
		 */

		wp_enqueue_script(
			$this->plugin_name,
			plugin_dir_url( __FILE__ ) . 'js/replace-plugin-name-common.js',
			array( 'jquery' ),
			$this->version,
			false
		);

	}

}
