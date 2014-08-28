<?php namespace js13kgames\connect\api\slack\services;

	// Internal dependencies
	use js13kgames\connect\api\slack;

	/**
	 * Incoming Webhook API Client
	 *
	 * @package     Js13kgames\Connect\API\Slack
	 * @version     0.0.1
	 * @author      Michal Chojnacki <m.chojnacki@muyo.pl>
	 * @copyright   2012-2014 js13kGames Team
	 * @link        http://js13kgames.com
	 */

	class IncomingWebhook extends slack\Service
	{
		const URI = '/services/hooks/incoming-webhook';

		public function post($channel, $message, $username = null, $iconUrl = null, $iconEmoji = null)
		{
			return $this->send($this->prepare('post', [
				'body'  => json_encode(
				[
					'channel'    => $channel,
					'text'       => $message,
					'username'   => $username,
					'icon_url'   => $iconUrl,
					'icon_emoji' => $iconEmoji
				])
			]));
		}
	}