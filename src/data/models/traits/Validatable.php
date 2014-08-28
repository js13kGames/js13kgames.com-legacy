<?php namespace js13kgames\data\models\traits;

	// Aliases
	use Validator;

	/**
	 * Validatable Trait
	 *
	 * @package     Js13kgames\Data\Models
	 * @version     0.0.1
	 * @author      Michal Chojnacki <m.chojnacki@muyo.pl>
	 * @copyright   2012-2014 js13kGames Team
	 * @link        http://js13kgames.com
	 */

	trait Validatable
	{
		/**
		 * {@see js13kgames\data\models\interfaces\Validatable::getValidator()}
		 */

		public static function getValidator(array $data)
		{
			return Validator::make($data, static::getValidationRules(), static::getValidationMessages());
		}
	}