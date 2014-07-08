<?php namespace js13kgames\connect\mail\handlers;

	// Internal dependencies
	use js13kgames\connect\mail\interfaces;

	/**
	 * Mailgun Handler
	 *
	 * @package     Js13kgames\Connect\Mail
	 * @version     0.0.1
	 * @author      Michal Chojnacki <m.chojnacki@muyo.pl>
	 * @copyright   2012-2014 js13kGames Team
	 * @link        http://js13kgames.com
	 */

	class Mailgun implements interfaces\Handler
	{
		/**
		 * @var \Mailgun\Mailgun    The underlying Mailgun SDK instance.
		 */

		private $mailgun;

		private $config;

		/**
		 * Create a new Mailer instance.
		 *
		 * @param   array   $config
		 */

		public function __construct($config)
		{
			$this->config = $config;
		}

		/**
		 * {@inheritDoc}
		 */

		public function send(interfaces\Message $message)
		{
			/* @var  mailgun\Message $message */
			return $this->mailgun()->sendMessage($this->config['domain'], $message->getMessageData(), $message->getAttachmentData());
		}

		/**
		 * {@inheritDoc}
		 *
		 * @return  mailgun\Message
		 */

		public function createMessage()
		{
			return new mailgun\Message();
		}

		protected function mailgun()
		{
			return $this->mailgun ?: $this->mailgun = new \Mailgun\Mailgun($this->config['api_key']);
		}
	}