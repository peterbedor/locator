<?php
/**
 * GeoLocator plugin for Craft CMS
 *
 * GeoLocator Model
 *
 * @author    Peter Bedor
 * @copyright Copyright (c) 2017 Peter Bedor
 * @link      https://www.bedor.me
 * @package   GeoLocator
 * @since     0.1.0
 */

namespace Craft;

class GeoLocatorModel extends BaseModel
{
    /**
     * Defines this model's attributes.
     *
     * @return array
     */
    protected function defineAttributes()
    {
        return array_merge(parent::defineAttributes(), [
			'ownerId' => AttributeType::Number,
			'fieldId' => AttributeType::Number,
			'ownerLocale' => AttributeType::Locale,
			'address' => AttributeType::String,
			'latitude' => [
				AttributeType::Number,
				'column' => ColumnType::Decimal,
				'length' => 12,
				'decimals' => 8
			],
			'longitude' => [
				AttributeType::Number,
				'column' => ColumnType::Decimal,
				'length' => 12,
				'decimals' => 8
			]
		]);
    }
}