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
 * Defines the plugin name, version, and two examples hooks for how to enqueue
 * the dashboard-specific stylesheet and JavaScript.
 *
 * @since 1.0.0
 */
class Replace_Plugin_Name_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since 1.0.0
	 * @access private
	 * @var string $plugin_name
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since 1.0.0
	 * @access private
	 * @var string $version
	 */
	private $version;

	/**
	 * The path for including HTML partials.
	 *
	 * @since 1.0.0
	 * @access private
	 * @var string $partials_path
	 */
	private $partials_path;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 1.0.0
	 *
	 * @var string $plugin_name   The name of the plugin.
	 * @var string $version       The version of this plugin.
	 * @var string $partials_path The path for including HTML partials.
	 */
	public function __construct( $plugin_name, $version, $partials_path ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->partials_path = $partials_path;

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

		wp_enqueue_style(
			$this->plugin_name,
			plugin_dir_url( __FILE__ ) . 'css/replace-plugin-name-public.css',
			array(),
			$this->version,
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

		wp_enqueue_script(
			$this->plugin_name,
			plugin_dir_url( __FILE__ ) . 'js/replace-plugin-name-public.js',
			array( 'jquery' ),
			$this->version,
			false
		);

	}

}
