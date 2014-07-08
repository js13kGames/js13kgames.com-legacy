<?php namespace js13kgames\connect\mail\interfaces;

	/**
	 * Mail Message Interface
	 *
	 * @package     Js13kgames\Connect\Mail
	 * @version     0.0.1
	 * @author      Michal Chojnacki <m.chojnacki@muyo.pl>
	 * @copyright   2012-2014 js13kGames Team
	 * @link        http://js13kgames.com
	 */

	interface Message
	{
		public function getFrom();

		/**
		 * Add a "from" address to the message.
		 *
		 * @param  string  $address
		 * @param  string  $name
		 * @return  $this
		 */

		public function setFrom($address, $name = null);

		public function getSender();
		/**
		 * Set the "sender" of the message.
		 *
		 * @param  string  $address
		 * @param  string  $name
		 * @return  $this
		 */

		public function setSender($address, $name = null);

		public function getReturnPath();
		/**
		 * Set the "return path" of the message.
		 *
		 * @param  string  $address
		 * @return  $this
		 */

		public function setReturnPath($address);

		public function getTo();
		/**
		 * Add a recipient to the message.
		 *
		 * @param  string|array  $address
		 * @param  string  $name
		 * @return  $this
		 */

		public function setTo($address, $name = null);

		public function getCc();
		/**
		 * Add a carbon copy to the message.
		 *
		 * @param  string  $address
		 * @param  string  $name
		 * @return  $this
		 */

		public function setCc($address, $name = null);

		public function getBcc();
		/**
		 * Add a blind carbon copy to the message.
		 *
		 * @param  string  $address
		 * @param  string  $name
		 * @return  $this
		 */

		public function SetBcc($address, $name = null);

		public function getReplyTo();

		/**
		 * Add a reply to address to the message.
		 *
		 * @param  string  $address
		 * @param  string  $name
		 * @return  $this
		 */

		public function setReplyTo($address, $name = null);

		public function getSubject();

		/**
		 * Set the subject of the message.
		 *
		 * @param  string  $subject
		 * @return  $this
		 */

		public function setSubject($subject);

		/**
		 * Set the message priority level.
		 *
		 * @param  int  $level
		 * @return  $this
		 */

		public function setPriority($level);

		/**
		 * Attach a file to the message.
		 *
		 * @param  string  $file
		 * @param  array   $options
		 * @return  $this
		 */

		public function attach($file, array $options = []);

		/**
		 * Attach in-memory data as an attachment.
		 *
		 * @param  string  $data
		 * @param  string  $name
		 * @param  array   $options
		 * @return  $this
		 */

		public function attachData($data, $name, array $options = []);

		/**
		 * Embed a file in the message and get the CID.
		 *
		 * @param  string  $file
		 * @return string
		 */

		public function embed($file);

		/**
		 * Embed in-memory data in the message and get the CID.
		 *
		 * @param  string  $data
		 * @param  string  $name
		 * @param  string  $contentType
		 * @return string
		 */

		public function embedData($data, $name, $contentType = null);

		public function setBody($content, $mime = 'text/html');

		public function setText($content, $mime = 'text/plain');

		public function setTags(array $tags);

		public function tag($tag);

		public function getCampaign();

		public function setCampaign($id);

		public function getCustomData();

		public function setCustomData($key, array $data);
	}