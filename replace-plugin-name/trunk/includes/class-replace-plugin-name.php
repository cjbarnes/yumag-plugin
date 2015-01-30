<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both
 * the public-facing side of the site and the dashboard.
 *
 * @since 1.0.0
 *
 * @package Replace_Plugin_Name
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
 *     $plugin = new Replace_Plugin_Name();
 *
 * we call:
 *
 *     $plugin = Replace_Plugin_Name::getInstance();
 *
 * @since 1.0.0
 */
class Replace_Plugin_Name {

	/**
	 * The loader that's responsible for maintaining and registering all hooks
	 * that power the plugin.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var Replace_Plugin_Name_Loader $loader
	 */
	protected $loader;

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
	 * @return Replace_Plugin_Name Instance of this class.
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

		$this->plugin_name = 'replace-plugin-name';
		$this->version = '1.0.0';

		$this->plugin_path = plugin_dir_path( dirname( __FILE__ ) );
		$this->partials_path_public = $this->plugin_path . 'public/partials/';
		$this->partials_path_admin = $this->plugin_path . 'admin/partials/';

		/*
		 * Call plugin init methods
		 */

		$this->load_dependencies();
		$this->set_locale();
		$this->define_common_hooks();

		if ( is_admin() ) {
			$this->define_admin_hooks();
		} else {
			$this->define_public_hooks();
		}

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
	 * - Replace_Plugin_Name_Loader. Orchestrates the hooks of the plugin.
	 * - Replace_Plugin_Name_i18n. Defines internationalization functionality.
	 * - Replace_Plugin_Name_Common. Defines all hooks that apply to both the
	 *   admin area and the public side of the site.
	 * - Replace_Plugin_Name_Admin. Defines all hooks for the admin area.
	 * - Replace_Plugin_Name_Public. Defines all hooks for the public side of
	 *   the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of
		 * the core plugin.
		 */
		require_once $this->plugin_path . 'includes/class-replace-plugin-name-loader.php';
		// Get the parent class for all Singleton classes.
		require_once $this->plugin_path . 'includes/class-replace-plugin-name-singleton.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once $this->plugin_path . 'includes/class-replace-plugin-name-i18n.php';

		/**
		 * The class responsible for defining all actions that occur across
		 * both the Dashboard and the public-facing side of the site.
		 */
		require_once $this->plugin_path . 'includes/class-replace-plugin-name-common.php';

		if ( is_admin() ) {

			/**
			 * The class responsible for defining all actions that occur in the
			 * Dashboard.
			 */
			require_once $this->plugin_path . 'admin/class-replace-plugin-name-admin.php';

		} else {

			/**
			 * The class responsible for defining all actions that occur in the
			 * public-facing side of the site.
			 */
			require_once $this->plugin_path . 'public/class-replace-plugin-name-public.php';

		}

		$this->loader = new Replace_Plugin_Name_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Replace_Plugin_Name_i18n class in order to set the domain and
	 * to register the hook with WordPress.
	 *
	 * @since 1.0.0
	 * @access private
	 *
	 * @see Replace_Plugin_Name_i18n
	 * @see Replace_Plugin_Name_Loader::add_action()
	 */
	private function set_locale() {

		$plugin_i18n = new Replace_Plugin_Name_i18n();
		$plugin_i18n->set_domain( $this->get_plugin_name() );

		$this->loader->add_action(
			'plugins_loaded',
			$plugin_i18n,
			'load_plugin_textdomain'
		);

	}

	/**
	 * Register all of the hooks related to both the dashboard functionality
	 * and the public-facing functionality of the plugin.
	 *
	 * @since 1.0.0
	 * @access private
	 *
	 * @see Replace_Plugin_Name_Common
	 * @see Replace_Plugin_Name_Loader::add_action()
	 * @see Replace_Plugin_Name_Loader::add_filter()
	 */
	private function define_common_hooks() {

		$plugin_common = new Replace_Plugin_Name_Common(
			$this->get_partials_path( 'public' ),
			$this->get_partials_path( 'admin' )
		);

		// Enqueue shared styles and scripts.
		$this->loader->add_action(
			'wp_enqueue_scripts',
			$plugin_common,
			'enqueue_scripts'
		);
		$this->loader->add_action(
			'admin_enqueue_scripts',
			$plugin_common,
			'enqueue_scripts'
		);

	}

	/**
	 * Register all of the hooks related to the admin functionality
	 * of the plugin.
	 *
	 * @since 1.0.0
	 * @access private
	 *
	 * @see Replace_Plugin_Name_Admin
	 * @see Replace_Plugin_Name_Loader::add_action()
	 * @see Replace_Plugin_Name_Loader::add_filter()
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Replace_Plugin_Name_Admin(
			$this->get_partials_path( 'admin' )
		);

		// Enqueue admin styles and scripts.
		$this->loader->add_action(
			'admin_enqueue_scripts',
			$plugin_admin,
			'enqueue_styles'
		);
		$this->loader->add_action(
			'admin_enqueue_scripts',
			$plugin_admin,
			'enqueue_scripts'
		);

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since 1.0.0
	 * @access private
	 *
	 * @see Replace_Plugin_Name_Public
	 * @see Replace_Plugin_Name_Loader::add_action()
	 * @see Replace_Plugin_Name_Loader::add_filter()
	 */
	private function define_public_hooks() {

		$plugin_public = new Replace_Plugin_Name_Public(
			$this->get_partials_path( 'public' )
		);

		// Enqueue public-facing styles and scripts.
		$this->loader->add_action(
			'wp_enqueue_scripts',
			$plugin_public,
			'enqueue_styles'
		);
		$this->loader->add_action(
			'wp_enqueue_scripts',
			$plugin_public,
			'enqueue_scripts'
		);

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since 1.0.0
	 *
	 * @see Replace_Plugin_Name_Loader::run()
	 */
	public function run() {
		$this->loader->run();
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
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since 1.0.0
	 *
	 * @return Replace_Plugin_Name_Loader Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
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
