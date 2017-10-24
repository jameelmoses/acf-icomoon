(function ($, undefined) {

	var select2_format = {
		'3': {
			data: {
				results: acf_icomoon
			},
			formatResult: function (css) {
				return "<span style='display: inline-block; font-size:18px; margin-right: 5px;' class='icon-" + css.id + "'></span> " + css.text;
			},
			formatSelection: function (css) {
				return "<span class='icon-" + css.id + "'></span> " + css.text;
			}
		},
		'4': {
			data: acf_icomoon,
			templateResult: function (css) {
				return $("<span style='display: inline-block; font-size:18px; margin-right: 5px; position: relativel; top: 2px;' class='icon-" + css.id + "'></span><span>" + css.text + "</span>");
			},
			templateSelection: function (css) {
				return $("<span class='icon-" + css.id + "'></span><span>" + css.text + "</span>");
			}
		}
	};

	/**
	 * Get config properties matching current Select2 version.
	 *
	 * @param {String} version
	 * @return {Object}
	 */
	function select2FormatProvider(version) {
		if(undefined !== version && undefined !== select2_format[version]) {
			return select2_format[version];
		}

		return select2_format['4'];
	}

	/**
	 * Detect which version of Select2 is loaded.
	 *
	 * @return {String|Boolean}
	 */
	function detectSelect2Version() {
		if(undefined === $.fn.select2) {
			return false;
		}

		return ('formatResult' in $.fn.select2.defaults) ? '3' : '4';
	}

	/**
	 * Initialize ACF field.
	 *
	 * @param $field
	 */
	function initialize_field($field) {

		var select2Version = detectSelect2Version();
		if(!select2Version) {
			return;
		}
		var formatProvider = select2FormatProvider( select2Version );
		var input = $field.find('input.acf-icomoon');
		var allowClear = $(input).attr('data-allow-clear') || 0;
		var opts = $.extend({
			dropdownCssClass: "bigdrop widefat",
			dropdownAutoWidth: true,
			allowClear: 1 == allowClear
		}, formatProvider);

		input.select2(opts);
	}

	if (typeof acf.add_action !== 'undefined') {

		/*
		 *  ready append (ACF5)
		 *
		 *  These are 2 events which are fired during the page load
		 *  ready = on page load similar to jQuery(document).ready()
		 *  append = on new DOM elements appended via repeater field
		 *
		 *  @type	event
		 *  @date	20/07/13
		 *
		 *  @param	jQueryel (jQuery selection) the jQuery element which contains the ACF fields
		 *  @return	n/a
		 */

		acf.add_action('ready append', function (jQueryel) {
			// search jQueryel for fields of type 'FIELD_NAME'
			acf.get_fields({type: 'icomoon'}, jQueryel).each(function () {
				initialize_field($(this));
			});
		});
	} else {
		/*
		 *  acf/setup_fields (ACF4)
		 *
		 *  This event is triggered when ACF adds any new elements to the DOM.
		 *
		 *  @type	function
		 *  @since	1.0.0
		 *  @date	01/01/12
		 *
		 *  @param	event		e: an event object. This can be ignored
		 *  @param	Element		postbox: An element which contains the new HTML
		 *
		 *  @return	n/a
		 */
		$(document).on('acf/setup_fields', function (e, postbox) {
			$(postbox).find('.field[data-field_type="icomoon"]').each(function () {
				console.log($(this));
				initialize_field($(this));
			});
		});
	}
})(jQuery);
