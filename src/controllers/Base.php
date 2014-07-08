<?php namespace js13kgames\controllers;

	// Aliases
	use View;

	/**
	 * Abstract Base Controller
	 *
	 * @package     Js13kgames\Controllers
	 * @version     0.0.1
	 * @author      Michal Chojnacki <m.chojnacki@muyo.pl>
	 * @copyright   2012-2014 js13kGames Team
	 * @link        http://js13kgames.com
	 */

	abstract class Base extends \Controller
	{
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