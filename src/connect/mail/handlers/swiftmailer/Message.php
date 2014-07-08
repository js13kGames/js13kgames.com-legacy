<?php namespace js13kgames\connect\mail\handlers\swiftmailer;

	// Internal dependencies
	use js13kgames\connect\mail\interfaces;

	/**
	 * Swiftmailer Message
	 *
	 * @package     Js13kgames\Connect\Mail
	 * @version     0.0.1
	 * @author      Michal Chojnacki <m.chojnacki@muyo.pl>
	 * @copyright   2012-2014 js13kGames Team
	 * @link        http://js13kgames.com
	 */

	class Message implements interfaces\Message
	{
		/**
		 * @var \Swift_Message  The Swift Message instance.
		 */

		protected $swift;

		/**
		 * Creates a new message instance.
		 *
		 * @param  \Swift_Message  $swift
		 */

		public function __construct(\Swift_Message $swift)
		{
			$this->swift = $swift;
		}

		/**
		 * {@inheritDoc}
		 */

		public function setFrom($address, $name = null)
		{
			$this->swift->setFrom($address, $name);

			return $this;
		}

		/**
		 * {@inheritDoc}
		 */

		public function setSender($address, $name = null)
		{
			$this->swift->setSender($address, $name);

			return $this;
		}

		/**
		 * {@inheritDoc}
		 */

		public function setReturnPath($address)
		{
			$this->swift->setReturnPath($address);

			return $this;
		}

		/**
		 * {@inheritDoc}
		 */

		public function setTo($address, $name = null)
		{
			return $this->addAddresses($address, $name, 'To');
		}

		/**
		 * {@inheritDoc}
		 */

		public function setCc($address, $name = null)
		{
			return $this->addAddresses($address, $name, 'Cc');
		}

		/**
		 * {@inheritDoc}
		 */

		public function SetBcc($address, $name = null)
		{
			return $this->addAddresses($address, $name, 'Bcc');
		}

		/**
		 * {@inheritDoc}
		 */

		public function setReplyTo($address, $name = null)
		{
			return $this->addAddresses($address, $name, 'ReplyTo');
		}

		/**
		 * {@inheritDoc}
		 */

		public function setSubject($subject)
		{
			$this->swift->setSubject($subject);

			return $this;
		}

		/**
		 * {@inheritDoc}
		 */

		public function setPriority($level)
		{
			$this->swift->setPriority($level);

			return $this;
		}

		/**
		 * {@inheritDoc}
		 */

		public function attach($file, array $options = array())
		{
			$attachment = $this->createAttachmentFromPath($file);

			return $this->prepAttachment($attachment, $options);
		}

		/**
		 * {@inheritDoc}
		 */

		public function attachData($data, $name, array $options = array())
		{
			$attachment = $this->createAttachmentFromData($data, $name);

			return $this->prepAttachment($attachment, $options);
		}

		/**
		 * {@inheritDoc}
		 */

		public function embed($file)
		{
			return $this->swift->embed(\Swift_Image::fromPath($file));
		}

		/**
		 * {@inheritDoc}
		 */

		public function embedData($data, $name, $contentType = null)
		{
			$image = \Swift_Image::newInstance($data, $name, $contentType);

			return $this->swift->embed($image);
		}

		/**
		 * {@inheritDoc}
		 */

		public function setBody($content, $mime = 'text/html')
		{
			return $this->swift->setBody($content, $mime);
		}

		/**
		 * {@inheritDoc}
		 */

		public function setText($content, $mime = 'text/html')
		{
			return $this->swift->addPart($content, $mime);
		}

		/**
		 * Prepare and attach the given attachment.
		 *
		 * @param  \Swift_Attachment  $attachment
		 * @param  array  $options
		 * @return \Illuminate\Mail\Message
		 */
		protected function prepAttachment($attachment, $options = array())
		{
			// First we will check for a MIME type on the message, which instructs the
			// mail client on what type of attachment the file is so that it may be
			// downloaded correctly by the user. The MIME option is not required.
			if (isset($options['mime']))
			{
				$attachment->setContentType($options['mime']);
			}

			// If an alternative name was given as an option, we will set that on this
			// attachment so that it will be downloaded with the desired names from
			// the developer, otherwise the default file names will get assigned.
			if (isset($options['as']))
			{
				$attachment->setFilename($options['as']);
			}

			$this->swift->attach($attachment);

			return $this;
		}

		/**
		 * Returns the underlying Swift Message instance.
		 *
		 * @return \Swift_Message
		 */

		public function getSwiftMessage()
		{
			return $this->swift;
		}

		/**
		 * Add a recipient to the message.
		 *
		 * @param  string|array  $address
		 * @param  string  $name
		 * @param  string  $type
		 * @return \Illuminate\Mail\Message
		 */

		protected function addAddresses($address, $name, $type)
		{
			if (is_array($address))
			{
				$this->swift->{"set{$type}"}($address, $name);
			}
			else
			{
				$this->swift->{"add{$type}"}($address, $name);
			}

			return $this;
		}

		/**
		 * Create a Swift Attachment instance.
		 *
		 * @param  string  $file
		 * @return \Swift_Attachment
		 */

		protected function createAttachmentFromPath($file)
		{
			return \Swift_Attachment::fromPath($file);
		}

		/**
		 * Create a Swift Attachment instance from data.
		 *
		 * @param  string  $data
		 * @param  string  $name
		 * @return \Swift_Attachment
		 */

		protected function createAttachmentFromData($data, $name)
		{
			return \Swift_Attachment::newInstance($data, $name);
		}

		/**
		 * Dynamically pass missing methods to the Swift instance.
		 *
		 * @param  string  $method
		 * @param  array   $parameters
		 * @return mixed
		 */

		public function __call($method, $parameters)
		{
			$callable = array($this->swift, $method);

			return call_user_func_array($callable, $parameters);
		}
	}