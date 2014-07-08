<?php namespace js13kgames\connect\mail\handlers\mailgun;

	/**
	 * Mailgun Message Attachment
	 *
	 * @package     Js13kgames\Connect\Mail
	 * @version     0.0.1
	 * @author      Michal Chojnacki <m.chojnacki@muyo.pl>
	 * @copyright   2012-2014 js13kGames Team
	 * @link        http://js13kgames.com
	 */

	class Attachment
	{
		public function __construct($path)
		{
			$this->attachment = array($path);
			return $this;
		}
	}