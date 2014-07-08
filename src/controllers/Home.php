<?php namespace js13kgames\controllers;

	// Aliases
	use Config, View;

	/**
	 * Home Page Controller
	 *
	 * @package     Js13kgames\Controllers
	 * @version     0.0.1
	 * @author      Michal Chojnacki <m.chojnacki@muyo.pl>
	 * @copyright   2012-2014 js13kGames Team
	 * @link        http://js13kgames.com
	 */

	class Home extends Base
	{
		/**
		 *
		 */

		public function index()
		{
			// Which template are we to use?
			$current = Config::get('games.edition_slug');
			$chosen  = $this->getChosenEdition();

			return $this->display('home.'.($chosen === $current ? 'current' : $chosen), [
				'form' => (new Entries)->prepareForm()
			]);
		}
	}