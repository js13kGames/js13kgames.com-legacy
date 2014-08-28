<?php namespace js13kgames\connect\api\slack;

	// External dependencies
	use GuzzleHttp;

	/**
	 * Slack Team Service API Client
	 *
	 * @package     Js13kgames\Connect\API\Slack
	 * @version     0.0.1
	 * @author      Michal Chojnacki <m.chojnacki@muyo.pl>
	 * @copyright   2012-2014 js13kGames Team
	 * @link        http://js13kgames.com
	 */

	class Service
	{
		const URI = '/services';

		private $config;

		private $token;

		private $client;

		/**
		 * {@inheritDoc}
		 */

		public function __construct(array $config, $token)
		{
			$this->config = $config;
			$this->token  = $token;
		}

		protected function client()
		{
			return $this->client ?: $this->client = new GuzzleHttp\Client([
				'base_url' => 'https://'.$this->config['team'].'.slack.com'
			]);
		}

		protected function send(GuzzleHttp\Message\RequestInterface $request)
		{
			return $this->client()->send($request);
		}

		protected function prepare($method, array $options = [])
		{
			$request = $this->client()->createRequest($method, static::URI, $options);
			$request->getQuery()->set('token', $this->token);

			return $request;
		}
	}