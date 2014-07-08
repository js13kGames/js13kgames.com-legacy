<?php namespace js13kgames\controllers;

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
			$submitter = new SubmitController();

			return View::make('index', array(
				'form' => $submitter->prepareForm()
			));
		}
	}