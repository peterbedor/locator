// ;(function ( $, window, document, undefined ) {
//
// 	var pluginName = "GeoLocatorFieldType",
// 		defaults = {
// 		};
//
// 	// Plugin constructor
// 	function Plugin( element, options ) {
// 		this.element = element;
//
// 		this.options = $.extend( {}, defaults, options) ;
//
// 		this._defaults = defaults;
// 		this._name = pluginName;
//
// 		this.init();
// 	}
//
// 	Plugin.prototype = {
//
// 		init: function(id) {
// 			var _this = this;
//
// 			$(function () {
//
// console.log(_this.options);
//
// 			});
// 		}
// 	};
//
// 	// A really lightweight plugin wrapper around the constructor,
// 	// preventing against multiple instantiations
// 	$.fn[pluginName] = function ( options ) {
// 		return this.each(function () {
// 			if (!$.data(this, "plugin_" + pluginName)) {
// 				$.data(this, "plugin_" + pluginName,
// 				new Plugin( this, options ));
// 			}
// 		});
// 	};
//
// })( jQuery, window, document );

var GeoLocator;

(function($, G) {
	G = function(settings) {
		this.apiKey = settings.apiKey;

		this.init();
	}

	G.prototype.init = function() {
		this.bindEvents();
	}

	G.prototype.bindEvents = function() {
		var scope = this;

		$('#fields-location_address').autoComplete({
			minChars: 3,
			delay: 500,
			renderItem: function(item, search) {
				var coords = item.geometry.coordinates,
					re;

				search = search.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');

				re = new RegExp("(" + search.split(' ').join('|') + ")", "gi");

				return '<div class="autocomplete-suggestion" data-lat="' + coords[0] + '" data-lng="' + coords[1] + '" data-val="' + item.place_name + '">' + item.place_name.replace(re, "<b>$1</b>") + '</div>';
			},
			onSelect: function(event, term, item) {
				// $('#fields-location_address').val(item.data('val'));
				$('#fields-location_latitude').val(item.data('lat'));
				$('#fields-location_longitude').val(item.data('lng'));

				event.preventDefault();
			},
			source: function(term, response) {
				var url = 'https://api.mapbox.com/geocoding/v5/mapbox.places/' + term + '.json?access_token=' + scope.apiKey;

				$.getJSON(url, function(data) {
					var results = [];

					if (data.features.length) {
						data.features.forEach(function(feature) {
							results.push(feature.place_name);
						});
					}

					response(data.features);
				});
			}
		});
	}

	GeoLocator = G;
})(jQuery, GeoLocator);