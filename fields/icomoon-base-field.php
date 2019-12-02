<?php

class acf_field_icomoon_base extends acf_field {

	var $defaults;

	function __construct() {
		// vars
		$this->name     = 'icomoon';
		$this->label    = __( 'Icon selector', 'acf-icomoon' );
		$this->category = __( 'Basic', 'acf' );
		$this->defaults = array(
			'allow_clear' => 0,
		);
		$this->l10n = array(
			'matches_1'				=> _x('One result is available, press enter to select it.',	'Select2 JS matches_1',	'acf'),
			'matches_n'				=> _x('%d results are available, use up and down arrow keys to navigate.',	'Select2 JS matches_n',	'acf'),
			'matches_0'				=> _x('No matches found',	'Select2 JS matches_0',	'acf'),
			'input_too_short_1'		=> _x('Please enter 1 or more characters', 'Select2 JS input_too_short_1', 'acf' ),
			'input_too_short_n'		=> _x('Please enter %d or more characters', 'Select2 JS input_too_short_n', 'acf' ),
			'input_too_long_1'		=> _x('Please delete 1 character', 'Select2 JS input_too_long_1', 'acf' ),
			'input_too_long_n'		=> _x('Please delete %d characters', 'Select2 JS input_too_long_n', 'acf' ),
			'selection_too_long_1'	=> _x('You can only select 1 item', 'Select2 JS selection_too_long_1', 'acf' ),
			'selection_too_long_n'	=> _x('You can only select %d items', 'Select2 JS selection_too_long_n', 'acf' ),
			'load_more'				=> _x('Loading more results&hellip;', 'Select2 JS load_more', 'acf' ),
			'searching'				=> _x('Searching&hellip;', 'Select2 JS searching', 'acf' ),
			'load_fail'           	=> _x('Loading failed', 'Select2 JS load_fail', 'acf' ),
		);

		// do not delete!
		parent::__construct();
	}

	/**
	 * Extract icons from icomoon stylesheet.
	 *
	 * @since 1.0.0
	 *
	 * @return array|bool
	 */
	public function parse_css() {

		$filepath = ACF_ICOMOON_DIR . 'assets/css/style.css';
		/**
		 * The path to the icomoon stylesheet.
		 *
		 * @since 1.0.0
		 *
		 * @param string $filepath default path
		 */
		$filepath = apply_filters( 'icomoon_filepath', $filepath );
		if ( ! file_exists( $filepath ) ) {
			return array();
		}

		// First try to load icons from the cache
		$cache_key = 'icon_moon_' . md5( $filepath );
		$out       = wp_cache_get( $cache_key );
		if ( ! empty( $out ) ) {
			return $out;
		}

		// If not extract them from the CSS file
		$contents = file_get_contents( $filepath );

		preg_match_all( '#.icon-(.*)::before#', $contents, $css );
		array_shift( $css );


		foreach ( $css[0] as $cs ) {
			$out[] = array( 'id' => $cs, 'text' => $cs );
		}

		// Cache 30 seconds
		wp_cache_set( $cache_key, $out, '', 30 );

		return $out;
	}

	/**
	 * Display the css based on the vars given for dynamic fonts url.
	 *
	 * @since 1.0.0
	 */
	public function display_css() {

		$base_url = ACF_ICOMOON_URL;

		$font_name = 'icomoon';
		/**
		 * The font's name
		 *
		 * @since 1.0.0
		 *
		 * @param string $font_name the default font's name
		 */
		$font_name = apply_filters( 'icomoon_font_family_name', $font_name );

		$font_urls = array(
			'woff2' => $base_url . 'assets/css/fonts/icomoon.woff?ousyjt',
			'ttf'  => $base_url . 'assets/css/fonts/icomoon.ttf?ousyjt',
			'woff' => $base_url . 'assets/css/fonts/icomoon.woff?ousyjt',
			'svg'  => $base_url . 'assets/css/fonts/icomoon.svg?ousyjt#icomoon'
		);
		/**
		 * The font's files URLs
		 *
		 * @since 1.0.0
		 *
		 * @param array $font_urls the default font's file URLs
		 */
		$font_urls = apply_filters( 'icomoon_fonts', $font_urls );

		?>
        <style type="text/css">
            @font-face {
              font-family: '<?php echo esc_attr( $font_name ); ?>';
              src:
								url('<?php echo esc_url( $font_urls['woff2'] ); ?>') format('woff2'),
								url('<?php echo esc_url( $font_urls['ttf'] ); ?>') format('truetype'),
              	url('<?php echo esc_url( $font_urls['woff'] ); ?>') format('woff'),
              	url('<?php echo esc_url( $font_urls['svg'] ); ?>') format('svg');
              font-weight: normal;
              font-style: normal;
            }
        </style>
		<?php
	}

	/**
	 * Enqueue assets for the Icomoon field in admin
	 *
	 * @since 1.0.0
	 */
	function input_admin_enqueue_scripts() {

		// bail ealry if no enqueue
		if( !acf_get_setting('enqueue_select2') ) return;

		// globals
		global $wp_scripts;

		// vars
		$major = acf_get_setting('select2_version');

		// attempt to find 3rd party Select2 version
		// - avoid including v3 CSS when v4 JS is already enququed
		if( isset($wp_scripts->registered['select2']) ) {
			$major = (int) $wp_scripts->registered['select2']->ver;
		}

		// v4
		if( $major == 4 ) {
			$version = '4.0';
			$script = acf_get_url("assets/inc/select2/4/select2.full.js");
			$style = acf_get_url("assets/inc/select2/4/select2.css");

		} else { // v3
			$version = '3.5.2';
			if ( version_compare( acf_get_setting( 'version' ), '5.5.0', '>=' ) ) {
				$script = acf_get_url("assets/inc/select2/3/select2.js");
				$style = acf_get_url("assets/inc/select2/3/select2.css");
			} else {
				$script = acf_get_url("assets/inc/select2/select2.js");
				$style = acf_get_url('assets/inc/select2/select2.css');
			}
		}

		// enqueue
		wp_enqueue_script('select2', $script, array('jquery'), $version );
		wp_enqueue_style('select2', $style, '', $version );

		wp_register_script(
			'acf-input-icomoon',
			ACF_ICOMOON_URL . 'assets/js/input.js',
			array( 'select2' ),
			ACF_ICOMOON_VER
		);

		// Localizing the script
		wp_localize_script( 'acf-input-icomoon', 'acf_icomoon', $this->parse_css() );

		$css_file = ACF_ICOMOON_URL . 'assets/css/style.css';
		/**
		 * The icomoon stylesheet's URL.
		 *
		 * @since 1.0.0
		 *
		 * @param string $css_file the default icomoon stylesheet's URL
		 */
		$css_file = apply_filters( 'icomoon_fileurl', $css_file );
		wp_register_style(
			'acf-input-icomoon',
			$css_file,
			array( 'select2' ),
			ACF_ICOMOON_VER
		);

		// Enqueuing
		wp_enqueue_style( 'acf-input-icomoon' );
		wp_enqueue_script( 'acf-input-icomoon' );
	}

	/**
	 * Display Icomoon style in head.
	 *
	 * @since 1.0.0
	 */
	public function input_admin_head() {
		$this->display_css();
	}
}
