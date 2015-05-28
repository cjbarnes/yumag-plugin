<?php

/**
 * Output form fields for filtering the Notices on the front end.
 *
 * @since 1.1.0
 *
 * @global WP_Query $wp_query The main query.
 *
 * @package YuMag_Plugin/public
 */

// Don't allow this file to be loaded directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $wp_query;

// Get common functionality class.
$plugin_common = YuMag_Plugin_Common::get_instance( $this->plugin );


/*
 * Get existing filter choices. The result is an array in this form:
 * $choices[ $meta_key ] = $meta_value
 */
$choices = array();
if ( ! empty( $wp_query->meta_query->queries ) && is_array( $wp_query->meta_query->queries ) ) {
	$temp_choices = array_filter( $wp_query->meta_query->queries, function ( $q ) {
		return ( ! empty( $q['value'] ) );
	});
	foreach ( $temp_choices as $q2 ) {
		$choices[ $q2['key'] ] = $q2['value'];
	}
}

?>
<form class="notice-filter-form" method="get">

	<!-- TODO: Notice Type categories -->

	<!-- Department dropdown -->
	<label class="notice-filter-label" for="wpcf-submission-department"><?php echo esc_html_x( 'Department', 'Notices filtering form', 'yumag-plugin' ); ?></label>
	<select class="notice-filter-field notice-filter-dropdown" name="department" id="wpcf-submission-department">
		<option value="" <?php if ( empty( $choices['wpcf-submission_department'] ) ) echo 'selected'; ?>><?php esc_html_e( 'All departments', 'yumag-plugin' ); ?></option>
		<?php
		// Get the department options that currently have data.
		$departments = $plugin_common->get_post_meta_column( 'wpcf-submission_department' );
		natcasesort( $departments );
		?>
		<?php foreach ( $departments as $department ) : ?>
			<option <?php if ( ! empty( $choices['wpcf-submission_department'] ) && ( $department === $choices['wpcf-submission_department'] ) ) echo 'selected'; ?>><?php esc_html_e( $department ); ?></option>
		<?php endforeach; ?>
	</select>

	<!-- College dropdown -->
	<label class="notice-filter-label" for="wpcf-submission-college"><?php echo esc_html_x( 'College', 'Notices filtering form', 'yumag-plugin' ); ?></label>
	<select class="notice-filter-field notice-filter-dropdown" name="college" id="wpcf-submission-college">
		<option value="" <?php if ( empty( $choices['wpcf-submission_college'] ) ) echo 'selected'; ?>><?php esc_html_e( 'All colleges', 'yumag-plugin' ); ?></option>
		<?php
		// Get the college options that currently have data.
		$colleges = $plugin_common->get_post_meta_column( 'wpcf-submission_college' );
		natcasesort( $colleges );
		?>
		<?php foreach ( $colleges as $college ) : ?>
			<option <?php if ( ! empty( $choices['wpcf-submission_college'] ) && ( $college === $choices['wpcf-submission_college'] ) ) echo 'selected'; ?>><?php esc_html_e( $college ); ?></option>
		<?php endforeach; ?>
	</select>

	<!-- Class-Of textbox -->
	<label class="notice-filter-label" for="wpcf-submission-class-of"><?php echo esc_html_x( 'Graduating year', 'Notices filtering form', 'yumag-plugin' ); ?></label>
	<input
		class="notice-filter-field notice-filter-text"
		name="class-of"
		id="wpcf-submission-class-of"
		type="number"
		step="1"
		min="1963"
		max="<?php echo date( 'Y' ); ?>"
		<?php if ( ! empty( $choices['wpcf-submission_class_of'] ) && ( 1962 < $choices['wpcf-submission_class_of'] ) && ( intval( date( 'Y' ) ) >= $choices['wpcf-submission_class_of'] ) ) echo 'value="' . intval( $choices['wpcf-submission_class_of'] ) . '"' ?>
	>

	<!-- TODO: Search box? -->

	<!-- TODO: Date range? -->

	<!-- Submit button -->
	<input class="notice-filter-button" type="submit" value="<?php echo esc_attr_x( 'Search', 'Notices filtering form submit button', 'yumag-plugin' ) ?>">

</form>
