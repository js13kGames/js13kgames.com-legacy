<?php namespace js13kgames\controllers;

	// Internal dependencies
	use js13kgames\data\models;

	// Aliases
	use App, Config, View;

	/**
	 * Abstract Base Controller
	 *
	 * @package     Js13kgames\Controllers
	 * @version     0.0.1
	 * @author      Michal Chojnacki <m.chojnacki@muyo.pl>
	 * @copyright   2012-2014 js13kGames Team
	 * @link        http://js13kgames.com
	 */

	abstract class Base extends \Illuminate\Routing\Controller
	{
		/**
		 * @var models\Edition
		 */

		private $edition;

		/**
		 * @var models\User
		 */

		protected $user;

		/**
		 *
		 */

		protected function getEdition()
		{
			if(null !== $this->edition) return $this->edition;

			// @todo Hardcoded the editions to avoid an additional DB query.
			if(!$_SERVER['JS13K_EDITION'] or !in_array($_SERVER['JS13K_EDITION'], ['2014', '2013', '2012']))
			{
				$_SERVER['JS13K_EDITION'] = Config::get('games.edition_slug');
			}

			// Cut down on boiler plates since all of the Controllers rely on this being available anyway, so might
			// as well check it right here.
			if(null === $this->edition = models\Edition::where('slug', '=', $_SERVER['JS13K_EDITION'])->first())
			{
				App::abort(404, 'The requested edition does not exist.');
			}

			return $this->edition;
		}

		/**
		 *
		 */

		protected function display($view, array $data = [])
		{
			$edition = $this->getEdition();

			$global = [
				'menu'    => View::make('layouts.menus.'.$edition->slug),
				'edition' => $edition
			];

			return View::make($view, array_merge($global, $data));
		}

		/**
		 * {@inheritDoc}
		 */

		protected function setupLayout()
		{
			if(null !== $this->layout)
			{
				$this->layout = View::make($this->layout);
			}
		}
	}