<?php namespace js13kgames\data\models;

	// External dependencies
	use js13kgames\utils;

	/**
	 * Category Model
	 *
	 * @package     Js13kgames\Data\Models
	 * @version     0.0.1
	 * @author      Michal Chojnacki <m.chojnacki@muyo.pl>
	 * @copyright   2012-2014 js13kGames Team
	 * @link        http://js13kgames.com
	 */

	class Category extends Base
	{
		/**
		 * @var bool    Whether the model should be automatically timestamped.
		 */

		public $timestamps = false;

		/**
		 * @var array   The name of the table associated with the model.
		 */

		protected $table = 'categories';

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

		public function edition()
		{
			return $this->belongsTo('js13kgames\data\models\Edition');
		}

		/**
		 *
		 */

		public function submissions()
		{
			return $this->belongsToMany('js13kgames\data\models\Submission');
		}

		/**
		 * {@inheritDoc}
		 */

		public function save(array $options = [])
		{
			$this->slug = utils\Str::slug($this->title);

			parent::save($options);
		}
	}