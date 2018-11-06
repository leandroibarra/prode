<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

abstract class Localizable extends Model
{
	/**
	 * Localized attributes.
	 *
	 * @var array
	 */
	protected $localizable = [];

	/**
	 * Whether or not to hide translated attributes e.g. name_en
	 *
	 * @var boolean
	 */
	protected $hideLocaleSpecificAttributes = true;

	/**
	 * Whether or not to append translatable attributes to array
	 * output e.g. name
	 *
	 * @var boolean
	 */
	protected $appendLocalizedAttributes = true;

	/**
	 * Make a new translatable model
	 *
	 * @param array $attributes
	 */
	public function __construct($attributes = [])
	{
		// We dynamically append localizable attributes to array output
		// and hide the localized attributes from array output
		foreach ($this->localizable as $localizableAttribute) {
			if ($this->appendLocalizedAttributes) {
				$this->appends[] = $localizableAttribute;
			}

			if ($this->hideLocaleSpecificAttributes) {
				foreach (locale()->supported() as $locale) {
					$this->hidden[] = $localizableAttribute.'_'.$locale;
				}
			}
		}

		parent::__construct($attributes);
	}

	/**
	 * Magic method for retrieving a missing attribute.
	 *
	 * @param string $attribute
	 * @return mixed
	 */
	public function __get($attribute)
	{
		// We determine the current locale and return the associated
		// locale-specific attribute e.g. name_en
		if (in_array($attribute, $this->localizable)) {
			$localeSpecificAttribute = $attribute.'_'.locale()->current();

			return $this->{$localeSpecificAttribute};
		}

		return parent::__get($attribute);
	}

	/**
	 * Magic method for calling a missing instance method.
	 *
	 * @param string $method
	 * @param array $arguments
	 * @return mixed
	 */
	public function __call($method, $arguments)
	{
		// We handle the accessor calls for all our localizable attributes
		// e.g. getNameAttribute()
		foreach ($this->localizable as $localizableAttribute) {
			if ($method === 'get'.Str::studly($localizableAttribute).'Attribute') {
				return $this->{$localizableAttribute};
			}
		}

		return parent::__call($method, $arguments);
	}
}