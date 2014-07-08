<?php

	$kernel = new nyx\framework\Kernel([
		'base'    => $baseDir,
		'app'     => $baseDir.'/instance',
		'config'  => $baseDir.'/instance/config',
		'public'  => $baseDir.'/public',
		'src'     => $baseDir.'/src',
		'storage' => $baseDir.'/instance/storage',
	], isset($_SERVER['JS13K_ENV']) ? $_SERVER['JS13K_ENV'] : 'production');

	// If by any chance the filters failed and we ended up with a wildcard request, override the subdomain based
	// edition pick with the default edition.
	if(!in_array($_SERVER['JS13K_EDITION'], ['2014', '2013', '2012']))
	{
		$_SERVER['JS13K_EDITION'] = $kernel->make('config')->get('games.edition_slug');
	}

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
				$router->get('', 'Entries@index');
				$router->get('{slug}/{category}', 'Entries@index')->where('slug', ".+")->where('category', ".+");
				$router->get('{slug}', 'Entries@show')->where('slug', ".+");
			});
		});
	});

	return $kernel;