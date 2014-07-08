<?php namespace js13kgames\controllers;

	// Aliases
	use Config, View;

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
		 *
		 */

		protected function getChosenEdition()
		{
			return $_SERVER['JS13K_EDITION'] ?: Config::get('games.edition_slug');
		}

		/**
		 *
		 */

		protected function display($view, array $data = [])
		{
			$global = [
				'menu' => View::make('layouts.menus.'.$this->getChosenEdition())
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