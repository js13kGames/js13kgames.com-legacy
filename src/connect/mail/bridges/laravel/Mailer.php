<?php namespace js13kgames\connect\mail\bridges\laravel;

	// External dependencies
	use Illuminate\Support\SerializableClosure;
	use Illuminate\View;
	use Illuminate\Container;

	// Internal dependencies
	use js13kgames\connect\mail\interfaces;

	// Aliases
	use Queue; // @todo Use DI.

	/**
	 * Laravel Mailer Service
	 *
	 * @package     Js13kgames\Connect\Mail
	 * @version     0.0.1
	 * @author      Michal Chojnacki <m.chojnacki@muyo.pl>
	 * @copyright   2012-2014 js13kGames Team
	 * @link        http://js13kgames.com
	 */

	class Mailer
	{
		/**
		 * @var View\Factory    The view environment instance.
		 */

		private $views;

		/**
		 * @var array   The global from address and name.
		 */

		private $from;

		/**
		 * @var \Illuminate\Container\Container     The IoC container instance.
		 */

		private $container;

		/**
		 * Create a new Mailer instance.
		 *
		 * @param   View\Factory    $view
		 */

		public function __construct(View\Factory $view)
		{
			$this->views = $view;
		}

		/**
		 * Sets the global from address and name.
		 *
		 * @param  string  $address
		 * @param  string  $name
		 */

		public function alwaysFrom($address, $name = null)
		{
			$this->from =
			[
				'address' => $address,
				'name'    => $name
			];
		}

		/**
		 * Send a new message when only a plain part.
		 *
		 * @param   string|array        $view
		 * @param   array               $data
		 * @param   callable|string     $callback
		 * @return  int
		 */

		public function plain($view, array $data, $callback)
		{
			return $this->send(['text' => $view], $data, $callback);
		}

		/**
		 * Send a new message using a view.
		 *
		 * @param   string|array        $view
		 * @param   array               $data
		 * @param   callable|string     $callback
		 * @return  int
		 */

		public function send($view, array $data, $callback)
		{
			/* @var interfaces\Handler  $handler */
			$handler = $this->container['mail.handler'];
			$view    = $this->parseView($view);
			$message = $data['message'] = $handler->createMessage();

			// Autopopulate the from address from our global config. Can be overridden by the builder later on
			// but eases the process of sending various mails from a base address perspective.
			if(isset($this->from['address']))
			{
				$message->setFrom($this->from['address'], $this->from['name']);
			}

			$this->callMessageBuilder($callback, $message);

			// Once we have retrieved the view content for the e-mail we will set the body
			// of this message using the HTML type, which will provide a simple wrapper
			// to creating view based emails that are able to receive arrays of data.
			$this->addContent($message, $view[0], $view[1], $data);

			return $handler->send($message);
		}


		/**
		 * Queue a new e-mail message for sending.
		 *
		 * @param  string|array  $view
		 * @param  array   $data
		 * @param  Closure|string  $callback
		 * @param  string  $queue
		 * @return void
		 */
		public function queue($view, array $data, $callback, $queue = null)
		{
			$callback = $this->buildQueueCallable($callback);

			Queue::push('mailer@handleQueuedMessage', compact('view', 'data', 'callback'), $queue);
		}

		/**
		 * Queue a new e-mail message for sending on the given queue.
		 *
		 * @param  string  $queue
		 * @param  string|array  $view
		 * @param  array   $data
		 * @param  Closure|string  $callback
		 * @return void
		 */
		public function queueOn($queue, $view, array $data, $callback)
		{
			$this->queue($view, $data, $callback, $queue);
		}

		/**
		 * Queue a new e-mail message for sending after (n) seconds.
		 *
		 * @param  int  $delay
		 * @param  string|array  $view
		 * @param  array  $data
		 * @param  Closure|string  $callback
		 * @param  string  $queue
		 * @return void
		 */
		public function later($delay, $view, array $data, $callback, $queue = null)
		{
			$callback = $this->buildQueueCallable($callback);

			Queue::later($delay, 'mailer@handleQueuedMessage', compact('view', 'data', 'callback'), $queue);
		}

		/**
		 * Queue a new e-mail message for sending after (n) seconds on the given queue.
		 *
		 * @param  string  $queue
		 * @param  int  $delay
		 * @param  string|array  $view
		 * @param  array  $data
		 * @param  Closure|string  $callback
		 * @return void
		 */
		public function laterOn($queue, $delay, $view, array $data, $callback)
		{
			$this->later($delay, $view, $data, $callback, $queue);
		}

		/**
		 * Build the callable for a queued e-mail job.
		 *
		 * @param  mixed  $callback
		 * @return mixed
		 */
		protected function buildQueueCallable($callback)
		{
			if ( ! $callback instanceof \Closure) return $callback;

			return serialize(new SerializableClosure($callback));
		}

		/**
		 * Handle a queued e-mail message job.
		 *
		 * @param  \Illuminate\Queue\Jobs\Job  $job
		 * @param  array  $data
		 * @return void
		 */
		public function handleQueuedMessage($job, $data)
		{
			$this->send($data['view'], $data['data'], $this->getQueuedCallable($data));

			$job->delete();
		}

		/**
		 * Get the true callable for a queued e-mail message.
		 *
		 * @param  array  $data
		 * @return mixed
		 */
		protected function getQueuedCallable(array $data)
		{
			if (str_contains($data['callback'], 'SerializableClosure'))
			{
				return with(unserialize($data['callback']))->getClosure();
			}

			return $data['callback'];
		}

		/**
		 * Add the content to a given message.
		 *
		 * @param  interfaces\Message   $message
		 * @param  string  $view
		 * @param  string  $plain
		 * @param  array   $data
		 */

		protected function addContent(interfaces\Message $message, $view, $plain, $data)
		{
			if(isset($view))
			{
				$message->setBody($this->getView($view, $data), 'text/html');
			}

			if(isset($plain))
			{
				$message->setText($this->getView($plain, $data), 'text/plain');
			}
		}

		/**
		 * Parse the given view name or array.
		 *
		 * @param  string|array  $view
		 * @return array
		 *
		 * @throws \InvalidArgumentException
		 */

		protected function parseView($view)
		{
			if(is_string($view)) return [$view, null];

			if(is_array($view))
			{
				// If the given view is an array with numeric keys, we will just assume that
				// both a "pretty" and "plain" view were provided, so we will return this
				// array as is, since must should contain both views with numeric keys.
				if(isset($view[0])) return $view;

				// If the view is an array, but doesn't contain numeric keys, we will assume
				// the the views are being explicitly specified and will extract them via
				// named keys instead, allowing the developers to use one or the other.
				return [array_get($view, 'html'), array_get($view, 'text')];
			}

			throw new \InvalidArgumentException("Invalid view.");
		}

		/**
		 * Call the provided message builder.
		 *
		 * @param   callable|string     $callback
		 * @param   interfaces\Message  $message
		 * @return  mixed
		 * @throws  \InvalidArgumentException
		 */

		protected function callMessageBuilder($callback, $message)
		{
			if(is_callable($callback)) return call_user_func($callback, $message);
			if(is_string($callback))   return $this->container[$callback]->mail($message);

			throw new \InvalidArgumentException("Invalid callback given.");
		}

		/**
		 * Render the given view.
		 *
		 * @param  string  $view
		 * @param  array   $data
		 * @return \Illuminate\View\View
		 */

		protected function getView($view, $data)
		{
			$cleaner = new \TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;
			$cleaner->setHTML($this->views->make($view, $data)->render());
			$cleaner->setUseInlineStylesBlock(true);

			return $cleaner->convert(false);
		}

		/**
		 * Get the view environment instance.
		 *
		 * @return \Illuminate\View\Factory
		 */

		public function getViewFactory()
		{
			return $this->views;
		}

		/**
		 * Set the IoC container instance.
		 *
		 * @param  \Illuminate\Container\Container  $container
		 * @return  $this
		 */

		public function setContainer(Container\Container $container)
		{
			$this->container = $container;

			return $this;
		}
	}