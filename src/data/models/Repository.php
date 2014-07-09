<?php namespace js13kgames\data\models;

	/**
	 * Repository Model
	 *
	 * @package     Js13kgames\Data\Models
	 * @version     0.0.1
	 * @author      Michal Chojnacki <m.chojnacki@muyo.pl>
	 * @copyright   2012-2014 js13kGames Team
	 * @link        http://js13kgames.com
	 */

	class Repository extends Typable
	{
		/**
		 * The types a Repository can be of.
		 */

		const TYPE_GITHUB  = 1;

		/**
		 * @var array   The name of the table associated with the model.
		 */

		protected $table = 'repositories';

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

		public function submission()
		{
			return $this->belongsTo('js13kgames\data\models\Submission');
		}
	}