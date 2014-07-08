<?php

	$kernel = new nyx\framework\Kernel([
		'base'    => $baseDir,
		'app'     => $baseDir.'/instance',
		'config'  => $baseDir.'/instance/config',
		'public'  => $baseDir.'/public',
		'src'     => $baseDir.'/src',
		'storage' => $baseDir.'/instance/storage',
	], isset($_SERVER['JS13K_ENV']) ? $_SERVER['JS13K_ENV'] : 'production');

	// Register our routes and additional services no sooner than just before a Request gets handled.
	$kernel->on(nyx\framework\definitions\Events::REQUEST_RECEIVED, function($event) use($kernel) {

		$router = $kernel->make('router');
		$log    = $kernel->make('log');
		$config = $kernel->make('config');

		// If the environment config specifies a DSN for Sentry, go ahead and sppol up the client.
		if(null !== $dsn = $config->get('debug.sentry.dsn'))
		{
			// Instantiate a buffer log (which we will later on flush *after* the Response has been sent to avoid
			// sending out additional HTTP requests while the end-user is waiting.
			$kernel->instance('log.buffer', $bufferHandler = new Monolog\Handler\BufferHandler(
				new Monolog\Handler\RavenHandler(new Raven_Client($dsn), Monolog\Logger::WARNING)
			));

			$log->getMonolog()->pushHandler($bufferHandler);

			// Create a delegate for the Exception Handler so we can log the errors (on top of displaying them)
			// when Sentry is available in the environment.
			$kernel->make('diagnostics.debug.handlers.exception')->add(function(nyx\diagnostics\debug\Inspector $inspector) use($kernel, $log) {

				$exception = $inspector->getException();

				// Since we're in dev, we are going to ignore HTTP Exceptions without messages (as those are automated) for now.
				if($exception instanceof Symfony\Component\HttpKernel\Exception\HttpException and !$exception->getMessage())
				{
					return;
				}

				$log->error($exception->getMessage(), [
					'exception' => $exception
				]);
			});
		}

		// Routing time.
		$router->group(['namespace' => 'js13kgames\controllers'], function() use($router)
		{
			// Home
			$router->get('/','Home@index');

			// Entries
			$router->group(['prefix' => 'entries'], function() use($router)
			{
				$router->get('',       'Entries@index');
				$router->get('{slug}', 'Entries@show')->where('slug', ".+");
			});

			// Account.
			$router->group(['prefix' => 'account'], function() use($router)
			{
				// Social auth.
				$router->get('social/callback',         'account\Social@endpoint');
				$router->get('social/login/{provider}', 'account\Social@login');
			});
		});
	});

	// Flush the log after the Response has been sent.
	$kernel->on(nyx\framework\definitions\Events::RESPONSE_SENT, function($event) use($kernel) {
		if($kernel->bound('log.buffer')) $kernel->make('log.buffer')->flush();
	});

	return $kernel;