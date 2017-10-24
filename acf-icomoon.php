<?php
/*
 Plugin Name: Advanced Custom Fields: IcoMoon
 Version: 1.0.2
 Plugin URI: http://www.jameelmoses.com
 Description: ACF IcoMoon select field
 Author: Jameel Moses
 Author URI: http://www.jameelmoses.com
 Domain Path: languages
 Text Domain: acf-icomoon

 ----

 Copyright 2017 Jameel Moses (hello@jameelmoses.com)

 This program is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with this program; if not, write to the Free Software
 Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

define( 'ACF_ICOMOON_VER', '1.0.2' );
define( 'ACF_ICOMOON_URL', plugin_dir_url( __FILE__ ) );
define( 'ACF_ICOMOON_DIR', plugin_dir_path( __FILE__ ) );

class acf_field_icomoon_plugin {

	/**
	 * Constructor.
	 *
	 * Load plugin's translation and register icomoon fields.
	 *
	 * @since 1.0.0
	 */
	function __construct() {

		add_action( 'init', array( __CLASS__, 'load_translation' ), 1 );

		// Register ACF fields
		add_action( 'acf/register_fields', array( __CLASS__, 'register_field_v4' ) );
		add_action( 'acf/include_field_types', array( __CLASS__, 'register_field_v5' ) );
	}

	/**
	 * Load plugin translation.
	 *
	 * @since 1.0.0
	 */
	public static function load_translation() {
		load_plugin_textdomain(
			'acf-icomoon',
			false,
			dirname( plugin_basename( __FILE__ ) ) . '/languages'
		);
	}

	/**
	 * Register Icomoon field for ACF v4.
	 *
	 * @since 1.0.0
	 */
	public static function register_field_v4() {
		include_once( ACF_ICOMOON_DIR . 'fields/icomoon-base-field.php' );
		include_once( ACF_ICOMOON_DIR . 'fields/icomoon-v4.php' );
	}

	/**
	 * Register Icomoon field for ACF v5.
	 *
	 * @since 1.0.0
	 */
	public static function register_field_v5() {

		$enqueue_select2 = acf_get_setting( 'enqueue_select2' );
		if ( is_null( $enqueue_select2 ) ) {
			acf_update_setting( 'enqueue_select2', true );
		}

		$select2_version = acf_get_setting( 'select2_version' );
		if ( is_null( $select2_version ) ) {
			acf_update_setting( 'select2_version', 3 );
		}

		include_once( ACF_ICOMOON_DIR . 'fields/icomoon-base-field.php' );
		include_once( ACF_ICOMOON_DIR . 'fields/icomoon-v5.php' );
	}
}

/**
 * Init plugin.
 *
 * @since 1.0.0
 */
function acf_field_icomoon_load() {
	new acf_field_icomoon_plugin();
}
add_action( 'plugins_loaded', 'acf_field_icomoon_load' );
