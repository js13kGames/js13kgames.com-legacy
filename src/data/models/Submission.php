<?php namespace js13kgames\data\models;

	// Aliases
	use nyx\utils;

	/**
	 * Submission Model
	 *
	 * @package     Js13kgames\Data\Models
	 * @version     0.0.1
	 * @author      Michal Chojnacki <m.chojnacki@muyo.pl>
	 * @copyright   2012-2014 js13kGames Team
	 * @link        http://js13kgames.com
	 */

	class Submission extends Base
	{
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
			return $this->belongsToMany('js13kgames\data\models\Category');
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
			$this->slug = utils\Str::slug($this->title);

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