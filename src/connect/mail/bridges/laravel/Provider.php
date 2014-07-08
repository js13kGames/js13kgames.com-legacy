<?php namespace js13kgames\connect\mail\bridges\laravel;

	// External dependencies
	use Illuminate\Support;
	use Illuminate\Container;

	// Internal dependencies
	use js13kgames\connect\mail;

	/**
	 * Laravel Mail Service Provider
	 *
	 * @package     Js13kgames\Connect\Mail
	 * @version     0.0.1
	 * @author      Michal Chojnacki <m.chojnacki@muyo.pl>
	 * @copyright   2012-2014 js13kGames Team
	 * @link        http://js13kgames.com
	 */

	class Provider extends Support\ServiceProvider
	{
		/**
		 * @var bool    Indicates if loading of the provider is deferred.
		 */

		protected $defer = false;

		/**
		 * Registers the service provider.
		 *
		 * @return void
		 */

		public function register()
		{
			$this->registerMailHandler();

			$this->app->bindShared('mailer', function($app)
			{
				// Once we have create the mailer instance, we will set a container instance
				// on the mailer. This allows us to resolve mailer classes via containers
				// for maximum testability on said classes instead of passing Closures.
				$mailer = (new mail\Mailer($app['view']))->setContainer($app);

				// If a "from" address is set, we will set it on the mailer so that all mail
				// messages sent by the applications will utilize the same "from" address
				// on each one, which makes the developer's life a lot more convenient.
				if($from = $app['config']['mail.from'] and isset($from['address']))
				{
					$mailer->alwaysFrom($from['address'], isset($from['name']) ? $from['name'] : null);
				}

				return $mailer;
			});
		}

		protected function isSwiftMailTransport()
		{
			return in_array($this->app['config']['mail.driver'], ['smtp', 'sendmail', 'mail']);
		}

		/**
		 * Register the Mail Handler instance.
		 *
		 * @throws  \InvalidArgumentException
		 */

		protected function registerMailHandler()
		{
			$config = $this->app['config']['mail'];

			if(in_array($config['driver'], ['smtp', 'sendmail', 'mail']))
			{
				$this->app['mail.handler'] = $this->app->share(function($app) use($config)
				{
					switch($config['driver'])
					{
						case 'smtp':
							$transport = $this->createSwiftSmtpTransport($config);
						break;

						case 'sendmail':
							$transport = $this->createSwiftSendmailTransport($config);
						break;

						default:
							$transport = $this->createSwiftMailTransport($config);
					}


					return new mail\handlers\Swiftmailer(new \Swift_Mailer($transport));
				});
			}
			else
			{
				switch($config['driver'])
				{
					case 'mailgun':

						$this->app['mail.handler'] = $this->app->share(function($app) use($config)
						{
							return new mail\handlers\Mailgun($config['drivers']['mailgun']);
						});

					break;

					default:
						throw new \InvalidArgumentException('Invalid mail driver.');
				}
			}
		}

		/**
		 *
		 * @param   array               $config
		 * @return  \Swift_Transport
		 */

		protected function createSwiftSmtpTransport($config)
		{
			// The Swift SMTP transport instance will allow us to use any SMTP backend
			// for delivering mail such as Sendgrid, Amazon SMS, or a custom server
			// a developer has available. We will just pass this configured host.
			$transport = \Swift_SmtpTransport::newInstance($config['host'], $config['port']);

			if(isset($config['encryption']))
			{
				$transport->setEncryption($config['encryption']);
			}

			// Once we have the transport we will check for the presence of a username
			// and password. If we have it we will set the credentials on the Swift
			// transporter instance so that we'll properly authenticate delivery.
			if(isset($config['username']) and isset($config['password']))
			{
				$transport->setUsername($config['username']);
				$transport->setPassword($config['password']);
			}

			return $transport;
		}

		/**
		 *
		 * @param   array               $config
		 * @return  \Swift_Transport
		 */

		protected function createSwiftSendmailTransport($config)
		{
			return \Swift_SendmailTransport::newInstance($config['sendmail']);
		}

		/**
		 *
		 * @param   array               $config
		 * @return  \Swift_Transport
		 */

		protected function createSwiftMailTransport($config)
		{
			return \Swift_MailTransport::newInstance();
		}


		/**
		 * Get the services provided by the provider.
		 *
		 * @return array
		 */

		public function provides()
		{
			return ['mailer', 'mail.handler'];
		}
	}