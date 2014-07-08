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

	class Profile extends models\Typable
	{
		/**
		 * The types a Social Profile can be of.
		 */

		const TYPE_GITHUB  = 1;
		const TYPE_TWITTER = 2;

		/**
		 * @var bool    Whether timestamps should be automatically maintained for this model.
		 */

		public $timestamps = false;

		/**
		 * @var string  The database table this model should be stored in.
		 */

		protected $table = 'users_profiles';

		/**
		 * {@inheritDoc}
		 */

		public static function bind(ExternalProfile $profile, models\User $user = null, array $attributes = [])
		{
			// If we were not given a User, we need to create one.
			$user = null === $user ? static::createUserFromProfile($profile) : static::populateUserFromProfile($user, $profile);

			// Build the Social Profile model.
			$model = new static(array_merge(
			[
				'user_id'  => $user->id,
				'uid'      => $profile->identifier,
				'email'    => $profile->emailVerified ?: $profile->email,
				'avatar'   => $profile->photoURL

			], $attributes));

			$model->save();

			// We are actually going to return the User, not the Profile.
			return $user;
		}

		/**
		 *
		 */

		protected static function createUserFromProfile(ExternalProfile $profile)
		{
			$user = new models\User;

			$user->email  = $profile->emailVerified ?: $profile->email;
			$user->active = $profile->emailVerified !== '';

			// Populate the User model based on the data in the external profile.
			static::populateUserFromProfile($user, $profile);

			// Set up a unique hash.
			$user->save();

			return $user;
		}

		/**
		 *
		 */

		protected static function populateUserFromProfile(models\User $user, ExternalProfile $profile)
		{
			$user->name     = $user->name     ?: ($profile->firstName ?: null);
			$user->surname  = $user->surname  ?: ($profile->lastName ?: null);

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