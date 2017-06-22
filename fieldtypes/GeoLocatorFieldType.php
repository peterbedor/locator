<?php

namespace Craft;

class GeoLocatorFieldType extends BaseFieldType
{
	/**
	 * Returns the name of the fieldtype.
	 *
	 * @return mixed
	 */
	public function getName()
	{
		return Craft::t('GeoLocator');
	}

	/**
	 * Returns the content attribute config.
	 *
	 * @return mixed
	 */
	public function defineContentAttribute()
	{
		return AttributeType::Mixed;
	}

	/**
	 * Returns the field's input HTML.
	 *
	 * @param string $name
	 * @param mixed  $value
	 * @return string
	 */
	public function getInputHtml($name, $value)
	{
		if (! $value) {
			$value = new GeoLocatorModel();
		}

		$id = craft()->templates->formatInputId($name);
		$namespacedId = craft()->templates->namespaceInputId($id);

		// Include JS and CSS
		$this->includeResources([
			'css' => [
				'geolocator/css/fields/vendor/autocomplete.css'
			],
			'js' => [
				'geolocator/js/fields/vendor/autocomplete.js',
				'geolocator/js/fields/fieldType.js'
			],
		]);

		$settings = craft()->plugins->getPlugin($this->getName())->getSettings();
		$apiKey = $settings->getAttribute('apiKey');

		return craft()->templates->render(
			'geolocator/fields/fieldType.twig',
			[
				'id' => $id,
				'name' => $name,
				'namespaceId' => $namespacedId,
				'values' => $value,
				'apiKey' => $apiKey,
			]
		);
	}

	/**
	 * Add resources to template
	 *
	 * @param array $resources
	 * @private
	 */
	private function includeResources(array $resources)
	{
		foreach($resources as $type => $items) {
			foreach($items as $item) {
				if ($type === 'js') {
					craft()->templates->includeJsResource($item);
				} else if ($type === 'css') {
					craft()->templates->includeCssResource($item);
				}
			}
		}
	}
}