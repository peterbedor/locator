<?php

namespace Craft;

class LocatorFieldType extends BaseFieldType
{
	/**
	 * Returns the name of the fieldtype.
	 *
	 * @return mixed
	 */
	public function getName()
	{
		return Craft::t('Locator');
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
			$value = new LocatorModel();
		}

		$id = craft()->templates->formatInputId($name);
		$namespacedId = craft()->templates->namespaceInputId($id);

		// Include JS and CSS
		$this->includeResources([
			'css' => [
				'locator/css/fields/vendor/autocomplete.css'
			],
			'js' => [
				'locator/js/fields/vendor/autocomplete.js',
				'locator/js/fields/locator.js'
			],
		]);

		$jsonVars = json_encode([
			'id' => $id,
			'name' => $name,
			'namespace' => $namespacedId,
			'prefix' => craft()->templates->namespaceInputId(''),
			'apiKey' => craft()->plugins->getPlugin($this->getName())->getSettings()->getAttribute('apiKey'),
		]);

		craft()->templates->includeJs("$('#{$namespacedId}-field').LocatorFieldType({$jsonVars});");

		return craft()->templates->render(
			'locator/fields/fieldType.twig',
			[
				'id' => $id,
				'name' => $name,
				'values' => $value
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