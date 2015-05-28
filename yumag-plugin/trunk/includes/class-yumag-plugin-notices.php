<?php

/**
 * Setup custom post type for alumni submissions
 *
 * @since 1.0.0
 *
 * @package YuMag_Plugin
 */

/**
 * Setup custom post type for alumni submissions.
 *
 * Included and instantiated by
 * `YuMag_Plugin_Common::load_dependencies()`.
 *
 * Uses the Singleton pattern.
 *
 * @since 1.0.0
 */
class YuMag_Plugin_Notices extends YuMag_Plugin_Singleton {

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

		// Register the custom post type.
		add_action( 'init', array( $this, 'register_notices_post_type' ), 0 );

		// Register taxonomies for the Notices custom post type.
		add_action( 'init', array( $this, 'register_notices_taxonomy' ), 1 );

		// Move the Notice Type metabox to the top of the main Edit Notice page.
		add_action( 'add_meta_boxes_yumag_notice', array( $this, 'move_meta_boxes' ), 1 );

		// Save an entry in the custom post type.
		add_action( 'save_post', array( $this, 'save_notice' ), 10, 3 );

		// Modify the public-site queries to make Notices filter options work.
		add_action( 'pre_get_posts', array( $this, 'notice_queries' ) );

	}

	/**
	 * Register a custom post type for alumni submissions.
	 *
	 * @since 1.0.0
	 */
	public static function register_notices_post_type() {

		$labels = array(
			'name'                => _x( 'Notices',
											'Post Type General Name',
											'yumag-plugin' ),
			'singular_name'       => _x( 'Notice',
											'Post Type Singular Name',
											'yumag-plugin' ),
			'menu_name'           => __( 'Notices',             'yumag-plugin' ),
			'name_admin_bar'      => __( 'Notice',             'yumag-plugin' ),
			'parent_item_colon'   => __( 'Parent Notice:',     'yumag-plugin' ),
			'all_items'           => __( 'All Notices',        'yumag-plugin' ),
			'add_new_item'        => __( 'Add New Notice',     'yumag-plugin' ),
			'add_new'             => __( 'Add New',            'yumag-plugin' ),
			'new_item'            => __( 'New Notice',         'yumag-plugin' ),
			'edit_item'           => __( 'Edit Notice',        'yumag-plugin' ),
			'update_item'         => __( 'Update Notice',      'yumag-plugin' ),
			'view_item'           => __( 'View Notice',        'yumag-plugin' ),
			'search_items'        => __( 'Search Notices',      'yumag-plugin' ),
			'not_found'           => __( 'Not found',          'yumag-plugin' ),
			'not_found_in_trash'  => __( 'Not found in Trash', 'yumag-plugin' ),
		);
		$rewrite = array(
			'slug'                => 'on-the-grapevine',
			'with_front'          => true,
			'pages'               => true,
			'feeds'               => true
		);
		$supports = array(
			'thumbnail',
			'comments',
			'custom-fields'
		);
		$args = array(
			'label'               => __( 'yumag_notice', 'yumag-plugin' ),
			'description'         => __( 'Alumni submissions to yu magazine', 'yumag-plugin' ),
			'labels'              => $labels,
			'supports'            => $supports,
			'taxonomies'          => array( 'post_tag', ' yumag_notice_type' ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => 7,
			'menu_icon'           => 'dashicons-testimonial',
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => true,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => true,
			'publicly_queryable'  => true,
			'rewrite'             => $rewrite,
			'capability_type'     => 'yumag_notice'
		);
		register_post_type( 'yumag_notice', $args );

	}

	/**
	 * Register the custom taxonomy for Notice types.
	 *
	 * @since 1.0.0
	 */
	public static function register_notices_taxonomy() {

		// Setup the Issue custom post type that is the basis for this plugin.
		$labels = array(
			'name'                       => _x( 'Notice Types',
													'Taxonomy General Name',
													'yumag-plugin' ),
			'singular_name'              => _x( 'Notice Type',
													'Taxonomy Singular Name',
													'yumag-plugin' ),
			'menu_name'                  => __( 'Types',
													'yumag-plugin' ),
			'all_items'                  => __( 'All Types',
													'yumag-plugin' ),
			'parent_item'                => __( 'Parent Type',
													'yumag-plugin' ),
			'parent_item_colon'          => __( 'Parent Type:',
													'yumag-plugin' ),
			'new_item_name'              => __( 'New Type Name',
													'yumag-plugin' ),
			'add_new_item'               => __( 'Add New Type',
													'yumag-plugin' ),
			'edit_item'                  => __( 'Edit Type',
													'yumag-plugin' ),
			'update_item'                => __( 'Update Type',
													'yumag-plugin' ),
			'separate_items_with_commas' => __( 'Separate Types with commas',
													'yumag-plugin' ),
			'search_items'               => __( 'Search Notice Types',
													'yumag-plugin' ),
			'add_or_remove_items'        => __( 'Add or remove Types',
													'yumag-plugin' ),
			'choose_from_most_used' => __( 'Choose from the most used Types',
													'yumag-plugin' ),
			'not_found'                  => __( 'Not Found',
													'yumag-plugin' ),
		);
		$rewrite = array(
			'slug'         => 'notice-type',
			'with_front'   => false,
			'hierarchical' => false
		);
		$capabilities = array(
			'manage_terms' => 'manage_categories',
			'edit_terms'   => 'manage_categories',
			'delete_terms' => 'manage_categories',
			'assign_terms' => 'edit_posts',
		);
		$args = array(
			'labels'                => $labels,
			'hierarchical'          => true,
			'public'                => true,
			'show_ui'               => true,
			'show_admin_column'     => true,
			'show_in_nav_menus'     => true,
			'show_tagcloud'         => false,
			'query_var'             => 'notice-type',
			'rewrite'               => $rewrite,
			'capabilities'          => $capabilities
		);
		register_taxonomy( 'yumag_notice_type', array( 'yumag_notice' ), $args );

		// Make sure the taxonomy/custom-post-type link was made.
		register_taxonomy_for_object_type( 'yumag_notice_type', 'yumag_notice' );

	}

	/**
	 * Move Notice Type taxonomy metabox into the main column.
	 *
	 * @since 1.0.0
	 *
	 * @global $wp_meta_boxes
	 */
	public function move_meta_boxes() {
		global $wp_meta_boxes;

		$post_type = 'yumag_notice';
		$box_name = 'yumag_notice_typediv';

		if ( isset( $wp_meta_boxes[ $post_type ]['side']['core'][ $box_name ] ) ) {

			unset( $wp_meta_boxes[ $post_type ]['side']['core'][ $box_name ] );
			add_meta_box(
				$box_name,
				_x( 'Notice Types', 'Taxonomy General Name', 'yumag-plugin' ),
				'post_categories_meta_box',
				$post_type,
				'side',
				'high',
				array( 'taxonomy' => 'yumag_notice_type' )
			);


		}

	}

	/**
	 * Additional code to run on creation/editing of a notice.
	 *
	 * @since 1.0.0
	 *
	 * @param int  $post_id The post ID.
	 * @param post $post    The post object.
	 * @param bool $update  Whether this is an existing post being updated o
	 *                      not.
	 */
	public function save_notice( $post_id, $post, $update ) {

		// Check this is the right type of post, and it isn't just an autosave.
		if ( ( 'yumag_notice' !== $post->post_type ) || wp_is_post_revision( $post_id ) ) {
			return;
		}

		/*
		 * Create a title for the post based on the submitter's name (which is
		 * a required field.)
		 */
		if ( isset( $_REQUEST['wpcf']['submission_name'] ) ) {

			// Don't re-run this action in an infinite loop!
			remove_action( 'save_post', array( $this, 'save_notice' ), 10 );

			$edits = array(
				'ID'         => $post_id,
				'post_title' => $_REQUEST['wpcf']['submission_name'] . ' - ' . $post->post_date
			);
			wp_update_post( $edits );

			// Reinstate the action hook.
			add_action( 'save_post', array( $this, 'save_notice' ), 10, 3 );

		}

	}

}
