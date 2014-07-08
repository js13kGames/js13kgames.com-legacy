<?php namespace js13kgames\connect\mail\handlers\mailgun;

	// Internal dependencies
	use js13kgames\connect\mail\interfaces;

	/**
	 * Mailgun Message
	 *
	 * Note: At most 3 tags can be set. This limit is not strictly enforced on this level though.
	 *
	 * @package     Js13kgames\Connect\Mail
	 * @version     0.0.1
	 * @author      Michal Chojnacki <m.chojnacki@muyo.pl>
	 * @copyright   2012-2014 js13kGames Team
	 * @link        http://js13kgames.com
	 */

	class Message implements interfaces\Message
	{
		private $attachment;

		private $tags = [];

		private $campaign;

		private $customData = [];

		private $from;

		private $to;

		private $cc;

		private $bcc;

		private $text;

		private $html;

		private $subject;

		/**
		 * {@inheritDoc}
		 */

		public function getFrom()
		{
			return $this->from;
		}

		/**
		 * {@inheritDoc}
		 */

		public function setFrom($address, $name = null)
		{
			$name = null !== $name ? $name : $address;

			$this->from = "{$name} <{$address}>";

			return $this;
		}

		/**
		 * {@inheritDoc}
		 */

		public function getTo()
		{
			return $this->to;
		}

		/**
		 * {@inheritDoc}
		 */

		public function setTo($address, $name = false)
		{
			$name = null !== $name ? $name : $address;

			$this->to = "{$name} <{$address}>";

			return $this;
		}

		/**
		 * {@inheritDoc}
		 */

		public function getCc()
		{
			return $this->cc;
		}

		/**
		 * {@inheritDoc}
		 */

		public function setCc($address, $name = false)
		{
			$name = null !== $name ? $name : $address;

			$this->cc = "{$name} <{$address}>";

			return $this;
		}

		/**
		 * {@inheritDoc}
		 */

		public function getBcc()
		{
			return $this->bcc;
		}

		/**
		 * {@inheritDoc}
		 */

		public function setBcc($address, $name = false)
		{
			$name = null !== $name ? $name : $address;

			$this->bcc = "{$name} <{$address}>";

			return $this;
		}

		/**
		 * {@inheritDoc}
		 */

		public function getReplyTo()
		{
			return $this->{'h:Reply-To'};
		}

		/**
		 * {@inheritDoc}
		 */

		public function setReplyTo($address, $name = null)
		{
			$this->{'h:Reply-To'} = $address;

			return $this;
		}

		/**
		 * {@inheritDoc}
		 */

		public function getBody()
		{
			return $this->html;
		}

		/**
		 * {@inheritDoc}
		 */

		public function setBody($content, $mime = 'text/html')
		{
			$this->html = $content;

			return $this;
		}

		/**
		 * {@inheritDoc}
		 */

		public function getText()
		{
			return $this->text;
		}

		/**
		 * {@inheritDoc}
		 */

		public function setText($content, $mime = 'text/html')
		{
			$this->text = $content;

			return $this;
		}

		/**
		 * {@inheritDoc}
		 */

		public function getSubject()
		{
			return $this->subject;
		}

		/**
		 * {@inheritDoc}
		 */

		public function setSubject($subject)
		{
			$this->subject = $subject;

			return $this;
		}

		// Sets
		public function setTags(array $tags)
		{
			$this->tags = $tags;

			return $this;
		}

		// Appends
		public function tag($tags)
		{
			$tags = is_array($tags) ? $tags : func_get_args();

			foreach($tags as $tag)
			{
				$this->tags[] = $tag;
			}

			return $this;
		}

		/**
		 * {@inheritDoc}
		 *
		 * @todo Sucks.
		 */

		public function attach($file, array $options = [])
		{
			if(isset($this->attachment))
			{
				$extraAttachment = new Attachment($file);
				$this->attachment->attachment[] = $extraAttachment->attachment[0];
			}
			else
			{
				$this->attachment = new Attachment($file);
			}

			return $this;
		}

		/**
		 * {@inheritDoc}
		 */

		public function embed($file)
		{
			$this->attachment->inline[] = $file;

			$pathArray = explode(DIRECTORY_SEPARATOR, $file);
			$file = $pathArray[count($pathArray)-1];

			return 'cid:' . $file;
		}

		/**
		 * {@inheritDoc}
		 */

		public function getSender()
		{
			return $this;
		}

		// @todo
		public function setSender($address, $name = null)
		{
			return $this;
		}

		// @todo
		public function setPriority($level)
		{
			return $this;
		}

		// @todo
		public function attachData($data, $name, array $options = [])
		{
			return $this;
		}

		// @todo
		public function embedData($data, $name, $contentType = null)
		{
			return $this;
		}

		/**
		 * {@inheritDoc}
		 */

		public function getReturnPath()
		{
			return $this;
		}

		// @todo
		public function setReturnPath($address, $name = null)
		{
			return $this;
		}

		public function getCampaign()
		{
			return $this->campaign;
		}

		public function setCampaign($id)
		{
			$this->campaign = (string) $id;

			return $this;
		}

		public function getCustomData($key = null)
		{
			return null !== $key ? $this->customData[$key] : $this->customData;
		}

		public function setCustomData($key, array $data)
		{
			$this->customData[$key] = $data;
		}

		// @todo toArray() instead.
		public function getMessageData()
		{
			// Public properties first.
			$data = [];

			if(isset($this->subject))        $data['subject'] = $this->subject;
			if(isset($this->text))           $data['text'] = $this->text;
			if(isset($this->html))           $data['html'] = $this->html;
			if(isset($this->from))           $data['from'] = $this->from;
			if(isset($this->{'h:Reply-To'})) $data['h:Reply-To'] = $this->{'h:Reply-To'};
			if(isset($this->to))             $data['to'] = $this->to;
			if(isset($this->cc))             $data['cc'] = $this->cc;
			if(isset($this->bcc))            $data['bcc'] = $this->bcc;

			if(!empty($this->tags))
			{
				$data['o:tag'] = array_slice($this->tags, 0, 3);
			}

			if(null !== $this->campaign)
			{
				$data['o:campaign'] = $this->campaign;
			}

			if(!empty($this->customData))
			{
				foreach($this->customData as $key => $customData)
				{
					$data['v:'.$key] = json_encode($customData);
				}
			}

			return $data;
		}

		// @todo toArray() instead.
		public function getAttachmentData()
		{
			return (array) $this->attachment;
		}
	}