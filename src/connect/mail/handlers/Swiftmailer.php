<?php namespace js13kgames\connect\mail\handlers;

	// Internal dependencies
	use js13kgames\connect\mail\interfaces;

	/**
	 * Swiftmailer Handler
	 *
	 * @package     Js13kgames\Connect\Mail
	 * @version     0.0.1
	 * @author      Michal Chojnacki <m.chojnacki@muyo.pl>
	 * @copyright   2012-2014 js13kGames Team
	 * @link        http://js13kgames.com
	 */

	class Swiftmailer implements interfaces\Handler
	{
		/**
		 * @var \Swift_Mailer   The Swift Mailer instance.
		 */

		private $swift;

		/**
		 *
		 */

		public function __construct(\Swift_Mailer $swift)
		{
			$this->swift = $swift;
		}

		/**
		 * {@inheritDoc}
		 */

		public function send(interfaces\Message $message)
		{
			/* @var  swiftmailer\Message $message */
			return $this->swift->send($message->getSwiftMessage());
		}

		/**
		 * {@inheritDoc}
		 *
		 * @return  swiftmailer\Message
		 */

		public function createMessage()
		{
			return new swiftmailer\Message(new \Swift_Message);
		}
	}