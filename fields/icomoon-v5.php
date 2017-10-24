<?php

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

class acf_field_icomoon extends acf_field_icomoon_base {

	/*
	*  render_field()
	*
	*  Create the HTML interface for your field
	*
	*  @param	$field - an array holding all the field's data
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*/
	function render_field( $field ) {
		// create Field HTML
		?>
        <input class="widefat acf-<?php echo esc_attr( $field['type'] ); ?>"
               value="<?php echo esc_attr( $field['value'] ); ?>"
               name="<?php echo esc_attr( $field['name'] ); ?>"
               data-placeholder="<?php _e( 'Select an icon', 'acf-icomoon' ); ?>"
               data-allow-clear="<?php echo esc_attr( $field['allow_clear'] ) ?>"/>
		<?php
	}

	/*
	*  render_field_settings()
	*
	*  Create extra options for your field. This is rendered when editing a field.
	*  The value of $field['name'] can be used (like bellow) to save extra data to the $field
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$field	- an array holding all the field's data
	*/
	function render_field_settings( $field ) {

		// allow clear
		acf_render_field_setting( $field,
			array(
				'label'        => __( 'Display clear button?', 'acf-icomoon' ),
				'instructions' => __( 'Whether or not a clear button is displayed when the select box has a selection.', 'acf-icomoon' ),
				'name'         => 'allow_clear',
				'type'         => 'true_false',
				'ui'           => 1,
			)
		);
	}
}

// create field
new acf_field_icomoon();