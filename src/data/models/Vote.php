<?php namespace js13kgames\data\models;

	/**
	 * Vote Model
	 *
	 * @package     Js13kgames\Data\Models
	 * @version     0.0.1
	 * @author      Michal Chojnacki <m.chojnacki@muyo.pl>
	 * @copyright   2012-2014 js13kGames Team
	 * @link        http://js13kgames.com
	 */

	class Vote extends Base
	{
		/**
		 * @var array   The name of the table associated with the model.
		 */

		protected $table = 'votes';

		/**
		 *
		 */

		public function user()
		{
			return $this->belongsTo('js13kgames\data\models');
		}

		/**
		 *
		 */

		public function submission()
		{
			return $this->belongsTo('js13kgames\data\models');
		}
	}