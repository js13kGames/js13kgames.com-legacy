<?php namespace js13kgames\controllers\account;

	// Internal dependencies
	use js13kgames\data\models;
	use js13kgames\controllers;

	// Aliases
	use Config, Redirect, Request, Session;

	/**
	 * Social Account Controller
	 *
	 * @package     Js13kgames\Controllers
	 * @version     0.0.1
	 * @author      Michal Chojnacki <m.chojnacki@muyo.pl>
	 * @copyright   2012-2014 js13kGames Team
	 * @link        http://js13kgames.com
	 */

	class Social extends controllers\Account
	{
		/**
		 *
		 */

		public function endpoint()
		{
			\Hybrid_Endpoint::process();
		}

		/**
		 *
		 */

		public function login($provider)
		{
			// Only keep track of the referring URL the first time we hit this action as we might end up here more than
			// once during the social auth procedure.
			if(!Session::has('url.intended')) Session::put('url.intended', Request::server('HTTP_REFERER'));


			$adapter = (new \Hybrid_Auth(Config::get('auth')))->authenticate($provider);

			dd($adapter);

			$fetchedProfile = $adapter->getUserProfile();

			// Define the model we are going to use to either retrieve or store the user's social profile.
			$profileModelClass = '\js13kgames\data\models\user\social\profiles\\'.$adapter->id;

			// If we've already got a stored profile for the given unique ID within the given network, retrieve the
			// underlying User model.
			if($profile = $profileModelClass::with('user')->where('uid', '=', $fetchedProfile->identifier)->first())
			{
				$this->user = $profile->user;
			}
			else
			{
				$this->user = $profileModelClass::bind($fetchedProfile, models\User::findByEmail($fetchedProfile->emailVerified ?: $fetchedProfile->email));
			}

			$adapter->logout();

			$this->transparentLogin($this->user);

			return Redirect::intended('/');
		}
	}