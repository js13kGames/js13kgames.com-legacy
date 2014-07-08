<?php namespace js13kgames\connect\mail\bridges\laravel;

	/**
	 * Laravel Mail Service Facade
	 *
	 * @package     Js13kgames\Connect\Mail
	 * @version     0.0.1
	 * @author      Michal Chojnacki <m.chojnacki@muyo.pl>
	 * @copyright   2012-2014 js13kGames Team
	 * @link        http://js13kgames.com
	 */

	class Mailer extends \Illuminate\Support\Facades\Facade
	{
		/**
		 * {@inheritDoc}
		 */

		protected static function getFacadeAccessor()
		{
			return 'mailer';
		}
	}