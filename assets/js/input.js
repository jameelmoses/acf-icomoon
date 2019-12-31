(function ($, undefined) {

	var select2_format = {
		data: acf_icomoon,
		templateResult: function (css) {
			return $("<span class='acf-icomoon-dropdown-icon icon-" + css.id + "' style='display: inline-block; font-size:18px; margin-right: 5px; position: relative; top: 2px;'></span><span class='acf-icomoon-dropdown-text'>" + css.text + "</span>");
		},
		templateSelection: function (css) {
			return $("<span class='acf-icomoon-dropdown-icon icon-" + css.id + "' style='display: inline-block; font-size:18px; margin-right: 5px; position: relative; top: 2px;'></span><span class='acf-icomoon-dropdown-text'>" + css.text + "</span>");
		}
	};

	/**
	 * Initialize ACF field.
	 *
	 * @param $field
	 */
	function initialize_field($field) {

		var formatProvider = {
			data: acf_icomoon,
			templateResult: function (css) {
				return $("<span class='acf-icomoon-dropdown-icon icon-" + css.id + "' style='display: inline-block; font-size:18px; margin-right: 5px; position: relative; top: 2px;'></span><span class='acf-icomoon-dropdown-text'>" + css.text + "</span>");
			},
			templateSelection: function (css) {
				return $("<span class='acf-icomoon-dropdown-icon icon-" + css.id + "' style='display: inline-block; font-size:18px; margin-right: 5px; position: relative; top: 2px;'></span><span class='acf-icomoon-dropdown-text'>" + css.text + "</span>");
			}
		};
		var input = $field.find('input.acf-icomoon');
		var allowClear = $(input).attr('data-allow-clear') || 0;
		var opts = $.extend({
			dropdownCssClass: 'acf-icomoon-dropdown',
			dropdownAutoWidth: false,
			width: '100%',
			allowClear: 1 == allowClear
		}, formatProvider);

		input.select2(opts);
	}

	/*
	 *  ready append
	 *
	 *  These are 2 events which are fired during the page load
	 *  ready = on page load similar to jQuery(document).ready()
	 *  append = on new DOM elements appended via repeater field
	 *
	 *  @type	event
	 *  @date	20/07/13
	 *
	 *  @param	$el (jQuery selection) the jQuery element which contains the ACF fields
	 *  @return	n/a
	 */

	acf.add_action('ready append', function ($el) {
		// search $el for fields of type 'FIELD_NAME'
		acf.get_fields({type: 'icomoon'}, $el).each(function () {
			initialize_field($(this));
		});
	});

})(jQuery);
