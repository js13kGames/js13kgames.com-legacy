<?php namespace js13kgames\console\commands;

	// Internal dependencies
	use js13kgames\data\models;

	/**
	 * Populate Command
	 *
	 * @package     Js13kgames\Console
	 * @version     0.1.0
	 * @author      Michal Chojnacki <m.chojnacki@muyo.pl>
	 * @copyright   2012-2014 js13kGames Team
	 * @link        http://js13kgames.com
	 */

	class Populate extends \Illuminate\Console\Command
	{
		/**
		 * @var string  The console command name.
		 */

		protected $name = 'populate';

		/**
		 * @var string  The console command description.
		 */

		protected $description = '';

		/**
		 * Execute the console command.
		 *
		 * @return mixed
		 */

		public function fire()
		{
			$this->call('migrate:reset');
			$this->call('migrate', ['--path'  => 'src/data/migrations']);
		}
	}
