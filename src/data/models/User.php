<?php namespace js13kgames\data\models;

	// External dependencies
	use Illuminate\Auth\UserInterface;

	/**
	 * User Model
	 *
	 * @package     Js13kgames\Data\Models
	 * @version     0.0.1
	 * @author      Michal Chojnacki <m.chojnacki@muyo.pl>
	 * @copyright   2012-2014 js13kGames Team
	 * @link        http://js13kgames.com
	 */

	class User extends Base implements UserInterface
	{
		/**
		 * @var array   The name of the table associated with the model.
		 */

		protected $table = 'users';

		/**
		 * @return  User
		 */

		public static function findByEmail($email)
		{
			return static::where('email', '=', $email)->first();
		}

		/**
		 * Returns the column name for the "remember me" token.
		 *
		 * @return  string
		 */

		public function votes()
		{
			return $this->hasMany('js13kgames\data\models\Vote');
		}

		/**
		 * Returns the unique identifier of the User.
		 *
		 * @return mixed
		 */

		public function getAuthIdentifier()
		{
			return $this->getKey();
		}

		/**
		 * Returns the User's password.
		 *
		 * @return  string
		 */

		public function getAuthPassword()
		{
			return $this->password;
		}

		/**
		 * Returns the "remember me" session token.
		 *
		 * @return string
		 */

		public function getRememberToken()
		{
			return $this->remember_token;
		}

		/**
		 * Sets the "remember me" session token.
		 *
		 * @param   string  $value
		 * @return  $this
		 */

		public function setRememberToken($value)
		{
			$this->remember_token = $value;

			return $this;
		}

		/**
		 * Returns the column name for the "remember me" token.
		 *
		 * @return  string
		 */

		public function getRememberTokenName()
		{
			return 'remember_token';
		}

		/**
		 *
		 */

		public function getFullName($fallbackToEmail = false)
		{
			if(!$this->name and $fallbackToEmail) return $this->email;

			return $this->name.' '.$this->surname;
		}
	}