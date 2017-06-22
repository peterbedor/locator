;(function($) {
	var pluginName = 'LocatorFieldType',
		defaults = {};

	// Plugin constructor
	function Plugin(element, options) {
		this.element = element;

		this.options = $.extend({}, defaults, options) ;

		this._defaults = defaults;
		this._name = pluginName;

		this.init();
	}

	Plugin.prototype = {
		init: function() {
			var _this = this;

			$(function() {
				var options = _this.options,
					namespace = options.namespace;

				$('#' + namespace + '_address').autoComplete({
					minChars: 3,
					delay: 500,
					renderItem: function(item, search) {
						var coords = item.location,
							name = item.formatted_address,
							re;

						search = search.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');

						re = new RegExp("(" + search.split(' ').join('|') + ")", "gi");

						return '<div class="autocomplete-suggestion" data-lat="' + coords.lat + '" data-lng="' + coords.lng + '" data-val="' + name + '">' + name.replace(re, "<b>$1</b>") + '</div>';
					},
					onSelect: function(event, term, item) {
						$('#' + namespace + '_latitude').val(item.data('lat'));
						$('#' + namespace + '_longitude').val(item.data('lng'));

						event.preventDefault();
					},
					source: function(term, response) {
						var url = 'https://api.geocod.io/v1/geocode?q=' + encodeURIComponent(term) + '&api_key=' + encodeURIComponent(options.apiKey);

						$.getJSON(url, function(data) {
							if (data.results && data.results.length) {
								response(data.results);
							}
						});
					}
				});
			});
		}
	};

	// A really lightweight plugin wrapper around the constructor,
	// preventing  multiple instantiations
	$.fn[pluginName] = function (options) {
		return this.each(function () {
			if (! $.data(this, 'plugin_' + pluginName)) {
				$.data(this, 'plugin_' + pluginName,
				new Plugin(this, options));
			}
		});
	};

})(jQuery, window, document);