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
				console.log(item);
				var coords = item.location,
					name = item.formatted_address,
					re;

				search = search.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');

				re = new RegExp("(" + search.split(' ').join('|') + ")", "gi");

				return '<div class="autocomplete-suggestion" data-lat="' + coords.lat + '" data-lng="' + coords.lng + '" data-val="' + name + '">' + name.replace(re, "<b>$1</b>") + '</div>';
			},
			onSelect: function(event, term, item) {
				// $('#fields-location_address').val(item.data('val'));
				$('#fields-location_latitude').val(item.data('lat'));
				$('#fields-location_longitude').val(item.data('lng'));

				event.preventDefault();
			},
			source: function(term, response) {
				var url = 'https://api.geocod.io/v1/geocode?q=' + encodeURIComponent(term) + '&api_key=' + encodeURIComponent(scope.apiKey);

				$.getJSON(url, function(data) {
					if (data.results && data.results.length) {
						response(data.results);
					}
				});
			}
		});
	}

	GeoLocator = G;
})(jQuery, GeoLocator);