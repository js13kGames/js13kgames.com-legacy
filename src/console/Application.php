<?php namespace js13kgames\console;

	// Aliases
	use Artisan;

	/**
	 * Console Application
	 *
	 * Temporarily using Laravel until Nyx' Console component is able to handle hook into the Kernel and properly
	 * handle migrations.
	 *
	 * @package     Js13kgames\Data\Migrations
	 * @version     0.1.0
	 * @author      Michal Chojnacki <m.chojnacki@muyo.pl>
	 * @copyright   2012-2014 js13kGames Team
	 * @link        http://js13kgames.com
	 */

	class Application extends \Illuminate\Console\Application
	{
		/**
		 * {@inheritDoc}
		 */

		public static function make($app)
		{
			$app->boot();

			$console = with($console = new static('Js13kGames', $app::VERSION))
				->setLaravel($app)
				->setAutoExit(false);

			$app->instance('artisan', $console);

			return $console;
		}

		/**
		 * {@inheritDoc}
		 */

		public function boot()
		{
			error_reporting(E_ALL ^ E_NOTICE);

			Artisan::add(new commands\Populate);

			if (isset($this->laravel['events']))
			{
				$this->laravel['events']
					->fire('artisan.start', array($this));
			}

			return $this;
		}
	}
