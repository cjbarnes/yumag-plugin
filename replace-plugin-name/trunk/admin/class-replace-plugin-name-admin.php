<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @since 1.0.0
 *
 * @package Replace_Plugin_Name/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to enqueue
 * the admin-specific stylesheet and JavaScript.
 *
 * @since 1.0.0
 */
class Replace_Plugin_Name_Admin {

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
	 * The path for including HTML partials.
	 *
	 * @since 1.0.0
	 * @access private
	 * @var string $partials_path The path of the folder for HTML partials.
	 */
	private $partials_path;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 1.0.0
	 *
	 * @var string $plugin_name The name of this plugin.
	 * @var string $version     The version of this plugin.
	 * @var string $partials_path The path for including HTML partials.
	 */
	public function __construct( $plugin_name, $version, $partials_path ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->partials_path = $partials_path;

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
		 * An instance of this class should be passed to the run() function
		 * defined in Replace_Plugin_Name_Admin_Loader as all of the hooks are
		 * defined in that particular class.
		 *
		 * The Replace_Plugin_Name_Admin_Loader will then create the
		 * relationship between the defined hooks and the functions defined in
		 * this class.
		 */

		wp_enqueue_style(
			$this->plugin_name,
			plugin_dir_url( __FILE__ ) . 'css/replace-plugin-name-admin.css',
			array(),
			$this->version,
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
		 * An instance of this class should be passed to the run() function
		 * defined in Replace_Plugin_Name_Admin_Loader as all of the hooks are
		 * defined in that particular class.
		 *
		 * The Replace_Plugin_Name_Admin_Loader will then create the
		 * relationship between the defined hooks and the functions defined in
		 * this class.
		 */

		wp_enqueue_script(
			$this->plugin_name,
			plugin_dir_url( __FILE__ ) . 'js/replace-plugin-name-admin.js',
			array( 'jquery' ),
			$this->version,
			false
		);

	}

}
