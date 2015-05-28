<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both
 * the public-facing side of the site and the dashboard.
 *
 * @since 1.0.0
 *
 * @package YuMag_Plugin
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, dashboard-specific hooks, and
 * public-facing site hooks. Also maintains the unique identifier of this plugin
 * as well as the current version of the plugin.
 *
 * Uses the Singleton pattern - so instead of calling:
 *
 *     $plugin = new YuMag_Plugin();
 *
 * we call:
 *
 *     $plugin = YuMag_Plugin::getInstance();
 *
 * @since 1.0.0
 */
class YuMag_Plugin {

	/**
	 * The unique identifier of this plugin.
	 *
	 * Also used for the translations text domain.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string $plugin_name
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string $version
	 */
	protected $version;

	/**
	 * The path to the plugin (used for includes and requires).
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string $plugin_path
	 */
	protected $plugin_path;

	/**
	 * The path to HTML partials used in the public-facing side of this plugin.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string $partials_path_public
	 */
	protected $partials_path_public;

	/**
	 * The path to HTML partials used in the admin area of this plugin.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string $partials_path_admin
	 */
	protected $partials_path_admin;

	/**
	 * Returns the instance of this class.
	 *
	 * The key method that enables the Singleton pattern for this class. Calls
	 * __construct() to create the class instance if it doesn't exist yet.
	 *
	 * @since 1.0.0
	 *
	 * @return YuMag_Plugin Instance of this class.
	 */
	public static function get_instance() {

		static $instance = null;
		if ( null === $instance ) {
			$instance = new static();
		}

		return $instance;
	}

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout
	 * the plugin. Load the dependencies, define the locale, and set the hooks for the admin area and the public-facing side of the site.
	 *
	 * Access `protected` enforces the Singleton pattern by disabling the `new`
	 * operator.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function __construct() {

		/*
		 * Init class properties
		 */

		$this->plugin_name = 'yumag-plugin';
		$this->version = '1.1.0';

		$this->plugin_path = plugin_dir_path( dirname( __FILE__ ) );
		$this->partials_path_public = $this->plugin_path . 'public/partials/';
		$this->partials_path_admin = $this->plugin_path . 'admin/partials/';

		/*
		 * Call plugin init methods
		 */

		$this->load_dependencies();

	}

	/**
	 * Private clone method to enforce the Singleton pattern.
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function __clone() {

	}

	/**
	 * Private unserialize method to enforce the Singleton pattern.
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function __wakeup() {

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - YuMag_Plugin_Singleton. Abstract class that enforces the
	 *   Singleton design pattern.
	 * - YuMag_Plugin_i18n. Defines internationalization functionality.
	 * - YuMag_Plugin_Common. Defines all hooks that apply to both the
	 *   admin area and the public side of the site.
	 * - YuMag_Plugin_Admin. Defines all hooks for the admin area.
	 * - YuMag_Plugin_Public. Defines all hooks for the public side of
	 *   the site.
	 *
	 * Instantiate the main plugin classes. They will then register their hooks.
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function load_dependencies() {

		$path = $this->plugin_path;

		// Get the parent class for all Singleton classes.
		require_once $path . 'includes/class-yumag-plugin-singleton.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once $path . 'includes/class-yumag-plugin-i18n.php';

		/**
		 * The class responsible for defining all actions that occur across
		 * both the Dashboard and the public-facing side of the site.
		 */
		require_once $path . 'includes/class-yumag-plugin-common.php';

		if ( is_admin() ) {

			/**
			 * The class responsible for defining all actions that occur in the
			 * Dashboard.
			 */
			require_once $path . 'admin/class-yumag-plugin-admin.php';

		} else {

			/**
			 * The class responsible for defining all actions that occur in the
			 * public-facing side of the site.
			 */
			require_once $path . 'public/class-yumag-plugin-public.php';

		}

		// Prepare internationalization class and hooks.
		$this->set_locale();

		/*
		 * Instantiate the classes that define and handle the plugin's
		 * functionality.
		 */
		YuMag_Plugin_Common::get_instance( $this );

		if ( is_admin() ) {
			YuMag_Plugin_Admin::get_instance( $this );
		} else {
			YuMag_Plugin_Public::get_instance( $this );
		}


	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the YuMag_Plugin_i18n class in order to set the domain and
	 * to register the hook with WordPress.
	 *
	 * @since 1.0.0
	 * @access private
	 *
	 * @see YuMag_Plugin_i18n
	 */
	private function set_locale() {

		$i18n = new YuMag_Plugin_i18n();
		$i18n->set_domain( $this->get_plugin_name() );

		add_action(	'plugins_loaded', array( $i18n, 'load_plugin_textdomain' ) );

	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since 1.0.0
	 *
	 * @return string The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since 1.0.0
	 *
	 * @return string The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Retrieve the path to this plugin's root directory.
	 *
	 * @since 1.0.0
	 *
	 * @return string The path to use in requires and includes.
	 */
	public function get_plugin_path() {
		return $this->plugin_path;
	}

	/**
	 * Retrieve the path to be used for including an HTML partial.
	 *
	 * @since 1.0.0
	 *
	 * @param  string $subpackage Default 'public'. Accepts 'public', 'admin'.
	 *                            The area of the site this partial is used in.
	 * @return string|false The path to the partials folder for this subpackage.
	 */
	public function get_partials_path( $subpackage = 'public' ) {

		switch ( $subpackage ) {

			case 'public':
				return $this->partials_path_public;

			case 'admin':
				return $this->partials_path_admin;

			default:
				return false;

		}

	}

}
