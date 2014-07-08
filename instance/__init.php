<?php

	$kernel = new nyx\framework\Kernel([
		'base'    => $baseDir,
		'app'     => $baseDir.'/instance',
		'config'  => $baseDir.'/instance/config',
		'public'  => $baseDir.'/public',
		'src'     => $baseDir.'/src',
		'storage' => $baseDir.'/instance/storage',
	], isset($_SERVER['JS13K_ENV']) ? $_SERVER['JS13K_ENV'] : 'production');

	// Register our routes no sooner than just before a Request gets handled.
	$kernel->on(nyx\framework\definitions\Events::REQUEST_RECEIVED, function($event) use($kernel) {

		$router = $kernel->make('router');


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

	return $kernel;