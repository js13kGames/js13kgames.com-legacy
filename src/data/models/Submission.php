<?php namespace js13kgames\data\models;

	// Internal dependencies
	use js13kgames\utils;

	// Aliases
	use Config, Mail, Validator;

	/**
	 * Submission Model
	 *
	 * @package     Js13kgames\Data\Models
	 * @version     0.0.1
	 * @author      Michal Chojnacki <m.chojnacki@muyo.pl>
	 * @copyright   2012-2014 js13kGames Team
	 * @link        http://js13kgames.com
	 */

	class Submission extends Base implements interfaces\Validatable
	{
		/**
		 * The traits of a Submission model instance.
		 */

		use traits\Validatable;

		/**
		 * @var array   The name of the table associated with the model.
		 */

		protected $table = 'submissions';

		/**
		 *
		 */

		public static function storagePath()
		{
			return base_path('public/games/');
		}

		/**
		 * {@inheritDoc}
		 */

		public static function getValidationMessages()
		{
			return [
				'spam.required' => 'You didn\'t do the math. Please fill the spam protection field.',
				'spam.spam'     => 'Your math is off. Please try again. Harder, this time.',
				'unique_slug'   => 'A game with the same name has already been submitted. Please choose a different name.',
				'reserved_slug' => 'The title of the game must not be one of: submit, desktop, mobile or server.',
				'if_server'     => 'A valid URL to the deployed game and a .zip with the server code must be provided for a game in the "Server" category.',
			];
		}

		/**
		 * {@inheritDoc}
		 */

		public static function getValidationRules()
		{
			return [
				'spam'             => 'required|spam',
				'token'            => 'required',
				'author'           => 'required|min:3',
				'email'            => 'required|email',
				'categories'       => 'required',
				'website_url'      => 'url',
				'github_url'       => 'url',
				'server_url'       => 'url|if_server',
				'title'            => 'required|min:2|max:100|unique_slug|reserved_slug',
				'description'      => 'required|min:10|max:1000',
				'file'             => 'mimes:zip|max:13',
				'file_server'      => 'mimes:zip|max:13|if_server',
				'small_screenshot' => 'mimes:jpeg,gif,png|max:100',
				'big_screenshot'   => 'mimes:jpeg,gif,png|max:100'
			];
		}

		/**
		 * {@inheritDoc}
		 */

		public function getValidator()
		{
			static $extended;

			if(null === $extended)
			{
				$extended = true;

				Validator::extend('unique_slug', function($attribute, $value, $parameters)
				{
					return !Submission::where('slug', '=', utils\Str::slug($value))->first() instanceof Submission;
				});

				Validator::extend('reserved_slug', function($attribute, $value, $parameters)
				{
					return !in_array($value, ['submit', 'desktop', 'mobile', 'server']);
				});
			}

			return Validator::make($this->attributes, static::getValidationRules(), static::getValidationMessages());
		}

		/**
		 *
		 */

		public function uri()
		{
			return '/entries/'.$this->slug;
		}

		/**
		 *
		 */

		public function path()
		{
			return static::storagePath().$this->slug.'/';
		}

		/**
		 *
		 */

		public function categories()
		{
			return $this->belongsToMany('js13kgames\data\models\Category', 'categories_submissions');
		}

		/**
		 *
		 */

		public function edition()
		{
			return $this->belongsTo('js13kgames\data\models\Edition');
		}

		/**
		 *
		 */

		public function user()
		{
			return $this->belongsTo('js13kgames\data\models\User');
		}

		/**
		 *
		 */

		public function repository()
		{
			return $this->hasOne('js13kgames\data\models\Repository');
		}

		/**
		 *
		 */

		public function votes()
		{
			return $this->hasMany('js13kgames\data\models\Vote');
		}

		/**
		 *
		 */

		public function getScore()
		{
			$score = 0;

			if($count = $this->votes->count())
			{
				foreach($this->votes as $vote)
				{
					$score += $vote->value;
				}

				$score = round($score / $count);
			}

			return $score;
		}

		/**
		 *
		 */

		public function getCategories()
		{
			$categories = [];

			foreach($this->categories as $category)
			{
				$categories[] = $category->title;
			}

			return $categories;
		}

		/**
		 *
		 */

		public function getUserVote()
		{
			if(!$user = \Auth::user()) return 0;

			// Looping here, instead of querying for the user's votes directly, since we're mainly using this on games
			// lists and thus running into n+1.
			foreach($this->votes as $vote)
			{
				if($user->id === $vote->user_id) return $vote->value;
			}

			return 0;
		}

		/**
		 * {@inheritDoc}
		 */

		public function save(array $options = [])
		{
			// If the edition is not set, assume it's the current one.
			if(null === $this->edition_id) $this->edition_id = Config::get('games.edition');

			// Auto-generate the slug.
			$this->slug = utils\Str::slug($this->title);

			if(!$this->exists())
			{
				// Create a directory to keep the Submission's assets in.
				if(!is_dir($this->path())) mkdir($this->path(), 0777);

				// Notify the contest owner.
				/*
				Mail::send('emails.submit.owner-note', ['submission' => $this], function($message)
				{
					$message->to(Config::get('games.mail'))->subject('[Js13kgames] New submission.');
				});
				*/
			}

			parent::save($options);
		}

		/**
		 *
		 */

		public function delete()
		{
			$it    = new \RecursiveDirectoryIterator($this->path());
			$files = new \RecursiveIteratorIterator($it, \RecursiveIteratorIterator::CHILD_FIRST);

			foreach($files as $file)
			{
				if($file->getFilename() === '.' || $file->getFilename() === '..') continue;

				if($file->isDir())
					rmdir($file->getRealPath());
				else
					unlink($file->getRealPath());
			}

			rmdir($this->path());

			parent::delete();
		}
	}