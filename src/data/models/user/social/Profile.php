<?php namespace js13kgames\data\models\user\social;

	// External dependencies
	use Hybrid_User_Profile as ExternalProfile;

	// Internal dependencies
	use js13kgames\data\models;

	/**
	 * User Social Profile Model
	 *
	 * @package     Js13kgames\Data\Models
	 * @version     0.0.1
	 * @author      Michal Chojnacki <m.chojnacki@muyo.pl>
	 * @copyright   2012-2014 js13kGames Team
	 * @link        http://js13kgames.com
	 */

	abstract class Profile extends models\Typable
	{
		/**
		 * The types a Social Profile can be of.
		 */

		const TYPE_GITHUB   = 1;
		const TYPE_TWITTER  = 2;
		const TYPE_FACEBOOK = 3;
		const TYPE_GOOGLE   = 4;

		/**
		 * @var string  The database table this model should be stored in.
		 */

		protected $table = 'users_profiles';

		/**
		 * {@inheritDoc}
		 */

		public static function bind(ExternalProfile $profile, models\User $user = null)
		{
			// If we were not given a User, we need to create one.
			if(null === $user) $user = static::createUserFromExternalProfile($profile);

			// Build the Social Profile model.
			$model = static::createFromExternalProfile($profile);

			$model->user_id = $user->id;
			$model->save();

			// We are actually going to return the User, not the Profile.
			return $user;
		}

		/**
		 *
		 */

		protected static function createFromExternalProfile(ExternalProfile $profile)
		{
			return new static([
				'uid'      => $profile->identifier,
				'email'    => $profile->emailVerified ?: $profile->email,
				'avatar'   => $profile->photoURL,
				'login'    => $profile->displayName
			]);
		}

		/**
		 *
		 */

		public static function createUserFromExternalProfile(ExternalProfile $profile)
		{
			$user = new models\User;
			$user->email = $profile->emailVerified ?: $profile->email;
			$user->save();

			return $user;
		}

		/**
		 * Returns the User this Social Profile belongs to.
		 *
		 * @return  \Illuminate\Database\Eloquent\Relations\BelongsTo
		 */

		public function user()
		{
			return $this->belongsTo('js13kgames\data\models\User', 'user_id');
		}
	}