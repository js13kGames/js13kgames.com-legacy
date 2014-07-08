<?php namespace js13kgames\connect\mail\interfaces;

	/**
	 * Mail Handler Interface
	 *
	 * @package     Js13kgames\Connect\Mail
	 * @version     0.0.1
	 * @author      Michal Chojnacki <m.chojnacki@muyo.pl>
	 * @copyright   2012-2014 js13kGames Team
	 * @link        http://js13kgames.com
	 */

	interface Handler
	{
		/**
		 */

		public function send(Message $message);

		/**
		 * Creates a new message instance.
		 *
		 * @return  Message
		 */

		public function createMessage();
	}