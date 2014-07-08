<?php return
[
	'fetch'       => PDO::FETCH_CLASS,
	'migrations'  => 'migrations',
	'default'     => 'sqlite',
	'connections' =>
	[
		'sqlite' => [
			'driver'   => 'sqlite',
			'database' => storage_path('db/production.sqlite'),
			'prefix'   => '',
		],
	],
];
