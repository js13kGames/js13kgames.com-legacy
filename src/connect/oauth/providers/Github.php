<?php namespace js13kgames\connect\oauth\providers;

	/**
	 * GitHub OAuth Provider
	 *
	 * @package     Js13kgames\Connect\OAuth
	 * @version     0.0.1
	 * @author      Michal Chojnacki <m.chojnacki@muyo.pl>
	 * @copyright   2012-2014 js13kGames Team
	 * @link        http://js13kgames.com
	 */

	class Github extends \Hybrid_Provider_Model_OAuth2
	{
		/**
		 *
		 */

		public $scope = "";

		/**
		 *
		 */

		function initialize()
		{
			parent::initialize();

			// Provider api end-points
			$this->api->api_base_url  = "https://api.github.com/";
			$this->api->authorize_url = "https://github.com/login/oauth/authorize";
			$this->api->token_url     = "https://github.com/login/oauth/access_token";
		}

		/**
		 *
		 */

		function getUserProfile()
		{
			$data = $this->api->api("user");

			if(!isset($data->id))
			{
				throw new \Exception( "User profile request failed! {$this->providerId} returned an invalid response.", 6 );
			}

			$this->user->profile->login       = @ $data->login;
			$this->user->profile->identifier  = @ $data->id;
			$this->user->profile->displayName = @ $data->name;
			$this->user->profile->description = @ $data->bio;
			$this->user->profile->photoURL    = @ $data->avatar_url;
			$this->user->profile->profileURL  = @ $data->html_url;
			$this->user->profile->email       = @ $data->email;
			$this->user->profile->webSiteURL  = @ $data->blog;
			$this->user->profile->region      = @ $data->location;

			if( ! $this->user->profile->displayName ){
				$this->user->profile->displayName = @ $data->login;
			}

			// request user emails from github api
			if( ! $data->email ){
				try{
					$emails = $this->api->api("user/emails");

					// fail gracefully, and let apps collect the email if not present
					if (is_array($emails) && !empty($emails[0]->email))
					{
					    $this->user->profile->email = $emails[0]->email;
					}
				}
				catch( \GithubApiException $e ){
					throw new \Exception( "User email request failed! {$this->providerId} returned an error: $e", 6 );
				}
			}

			return $this->user->profile;
		}
	}