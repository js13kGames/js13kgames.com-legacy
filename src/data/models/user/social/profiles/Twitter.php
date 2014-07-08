<?php namespace js13kgames\data\models\user\social\profiles;

	// External dependencies
	use Hybrid_User_Profile as ExternalProfile;

	// Internal dependencies
	use js13kgames\data\models;

	/**
	 * User Twitter Profile Model
	 *
	 * @package     Js13kgames\Data\Models
	 * @version     0.0.1
	 * @author      Michal Chojnacki <m.chojnacki@muyo.pl>
	 * @copyright   2012-2014 js13kGames Team
	 * @link        http://js13kgames.com
	 */

	class Twitter extends models\user\social\Profile
	{
		const TYPE = models\user\social\Profile::TYPE_TWITTER;

		/**
		 *
		 */

		protected static function createFromExternalProfile(ExternalProfile $profile)
		{
			$model = parent::createFromExternalProfile($profile);
			$model->login = $profile->displayName;

			return $model;
		}
	}