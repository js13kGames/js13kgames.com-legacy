<?php namespace js13kgames\connect\api\slack\services;

	// Internal dependencies
	use js13kgames\connect\api\slack;

	/**
	 * Slackbot API Client
	 *
	 * @package     Js13kgames\Connect\API\Slack
	 * @version     0.0.1
	 * @author      Michal Chojnacki <m.chojnacki@muyo.pl>
	 * @copyright   2012-2014 js13kGames Team
	 * @link        http://js13kgames.com
	 */

	class Bot extends slack\Service
	{
		const URI = '/services/hooks/slackbot';

		public function post($channel, $message)
		{
			return $this->send($this->prepare('post', [
				'body'  => $message,
				'query' => [
					'channel' => '#'.$channel
				]
			]));
		}
	}