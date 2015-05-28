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
if ( ! empty( $wp_query->meta_query->queries )
&& is_array( $wp_query->meta_query->queries ) ) {
	$temp_choices = array_filter( $wp_query->meta_query->queries, function ( $q ) {
		return ( ! empty( $q['value'] ) );
	});
	foreach ( $temp_choices as $q2 ) {
		$choices[ $q2['key'] ] = $q2['value'];
	}
}
if ( ! empty( $wp_query->tax_query->queries )
&& is_array( $wp_query->tax_query->queries ) ) {

	foreach ( $wp_query->tax_query->queries as $q ) {
		if ( ! empty( $q['taxonomy'] )
		&& ( 'yumag_notice_type' === $q['taxonomy'] )
		&& ! empty( $q['terms'][0] ) ) {
			$choices['yumag_notice_type'] = $q['terms'][0];
		}
	}

}

?>
<form class="notice-filter-form" method="get">

<table class="notice-filter-table">
<tbody>

<!-- Category dropdown -->
<tr>
	<th>
		<label class="notice-filter-label" for="yumag-notice-type"><?php echo esc_html_x( 'Category', 'Notices filtering form', 'yumag-plugin' ); ?></label>
	</th>
	<td>
		<?php
		$args = array(
			'show_option_all' => _x( 'All categories', 'Notices filtering form', 'yumag-plugin' ),
			'orderby'         => 'NAME',
			'name'            => 'type',
			'id'              => 'yumag-notice-type',
			'class'           => 'notice-filter-field notice-filter-dropdown',
			'taxonomy'        => 'yumag_notice_type',
			'value_field'     => 'slug'
		);
		if ( ! empty( $choices[ 'yumag_notice_type' ] )
		&& term_exists( $choices[ 'yumag_notice_type' ], 'yumag_notice_type' ) ) {
			$term = get_term_by( 'slug', $choices[ 'yumag_notice_type' ], 'yumag_notice_type' );
			$args['selected'] = $term->term_id;
		}
		wp_dropdown_categories( $args );
		?>
	</td>
</tr>

<!-- Department dropdown -->
<tr>
	<th>
		<label class="notice-filter-label" for="wpcf-submission-department"><?php echo esc_html_x( 'Department', 'Notices filtering form', 'yumag-plugin' ); ?></label>
	</th>
	<td>
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
	</td>
</tr>

<!-- College dropdown -->
<tr>
	<th>
		<label class="notice-filter-label" for="wpcf-submission-college"><?php echo esc_html_x( 'College', 'Notices filtering form', 'yumag-plugin' ); ?></label>
	</th>
	<td>
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
	</td>
</tr>

<!-- Class-Of textbox -->
<tr>
	<th>
		<label class="notice-filter-label" for="wpcf-submission-class-of"><?php echo esc_html_x( 'Graduating Year', 'Notices filtering form', 'yumag-plugin' ); ?></label>
	</th>
	<td>
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
	</td>
</tr>

<!-- Submit button -->
<tr>
	<td class="notice-filter-span-2" colspan="2">
		<input class="notice-filter-button" type="submit" value="<?php echo esc_attr_x( 'Search', 'Notices filtering form submit button', 'yumag-plugin' ) ?>">
	</td>
</tr>

	<!-- TODO: Search box? -->

	<!-- TODO: Date range? -->

</tbody>
</table>

</form>
