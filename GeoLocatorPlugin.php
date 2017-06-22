<?php
namespace Craft;

class GeoLocatorPlugin extends BasePlugin
{
	/**
	 * @return mixed
	 */
	public function init()
	{
		parent::init();
	}

	/**
	 * Returns the user-facing name.
	 *
	 * @return mixed
	 */
	public function getName()
	{
		 return Craft::t('GeoLocator');
	}

	/**
	 * Plugins can have descriptions of themselves displayed on the Plugins page by adding a getDescription() method
	 * on the primary plugin class:
	 *
	 * @return mixed
	 */
	public function getDescription()
	{
		return Craft::t('A simple plugin to geolocate and store location based information with an entry');
	}

	/**
	 * Plugins can have links to their documentation on the Plugins page by adding a getDocumentationUrl() method on
	 * the primary plugin class:
	 *
	 * @return string
	 */
	public function getDocumentationUrl()
	{
		return '???';
	}

	/**
	 * Plugins can now take part in Craft’s update notifications, and display release notes on the Updates page, by
	 * providing a JSON feed that describes new releases, and adding a getReleaseFeedUrl() method on the primary
	 * plugin class.
	 *
	 * @return string
	 */
	public function getReleaseFeedUrl()
	{
		return '???';
	}

	/**
	 * Returns the version number.
	 *
	 * @return string
	 */
	public function getVersion()
	{
		return '0.1.0';
	}

	/**
	 * As of Craft 2.5, Craft no longer takes the whole site down every time a plugin’s version number changes, in
	 * case there are any new migrations that need to be run. Instead plugins must explicitly tell Craft that they
	 * have new migrations by returning a new (higher) schema version number with a getSchemaVersion() method on
	 * their primary plugin class:
	 *
	 * @return string
	 */
	public function getSchemaVersion()
	{
		return '0.1.0';
	}

	/**
	 * Returns the developer’s name.
	 *
	 * @return string
	 */
	public function getDeveloper()
	{
		return 'Peter Bedor';
	}

	/**
	 * Returns the developer’s website URL.
	 *
	 * @return string
	 */
	public function getDeveloperUrl()
	{
		return 'https://www.bedor.me';
	}

	/**
	 * Returns whether the plugin should get its own tab in the CP header.
	 *
	 * @return bool
	 */
	public function hasCpSection()
	{
		return false;
	}

	/**
	 * Defines the attributes that model your plugin’s available settings.
	 *
	 * @return array
	 */
	protected function defineSettings()
	{
		return [
			'apiKey' => [
				AttributeType::String,
				'label' => 'MapBox API Key',
				'default' => ''
			],
		];
	}

	/**
	 * Returns the HTML that displays your plugin’s settings.
	 *
	 * @return mixed
	 */
	public function getSettingsHtml()
	{
	   return craft()->templates->render('geolocator/settings', [
		   'settings' => $this->getSettings()
	   ]);
	}
}