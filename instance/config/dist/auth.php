<?php return [
	'driver' => 'eloquent',
	'model'  => 'js13kgames\data\models\User',
	'table'  => 'users',
	'base_url'   => 'http://js13kgames.com/account/social/callback',
	"debug_mode" => false,
	"debug_file" => storage_path('logs/hybridauth.txt'),
	'providers' =>
	[
		"Github" => [
			"enabled"     => true,
			"keys"        => [ "id" => null, "secret" => null],
			"scope"       => "user:email,write:repo_hook",
			"wrapper"     => [
				"path"  =>  base_path('src/connect/oauth/providers/Github.php'),
				"class" => 'js13kgames\connect\oauth\providers\Github'
			]
		],
		'Twitter' =>
		[
			'enabled' => true,
			'keys'    => ['key' => null, 'secret' => null],
			"display" => "page"
		]
	]
];