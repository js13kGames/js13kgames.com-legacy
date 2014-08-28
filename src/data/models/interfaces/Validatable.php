<?php namespace js13kgames\data\models\interfaces;

	/**
	 * Validatable Interface
	 *
	 * @package     Js13kgames\Data\Models
	 * @version     0.0.1
	 * @author      Michal Chojnacki <m.chojnacki@muyo.pl>
	 * @copyright   2012-2014 js13kGames Team
	 * @link        http://js13kgames.com
	 */

	interface Validatable
	{
		/**
		 *
		 */

		public static function getValidationMessages();

		/**
		 *
		 */

		public static function getValidationRules();

		/**
		 *
		 */

		public static function getValidator(array $data);
	}