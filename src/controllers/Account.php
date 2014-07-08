<?php namespace js13kgames\controllers;

	// Internal dependencies
	use js13kgames\data\models;

	// Aliases
	use Auth;

	/**
	 * Account Controller
	 *
	 * @package     Js13kgames\Controllers
	 * @version     0.0.1
	 * @author      Michal Chojnacki <m.chojnacki@muyo.pl>
	 * @copyright   2012-2014 js13kGames Team
	 * @link        http://js13kgames.com
	 */

	class Account extends Base
	{
		/**
		 *
		 */

		protected function transparentLogin(models\User $user, $remember = true)
		{
			Auth::login($user, $remember);

			return $this->user = $user;
		}
	}