<?php

	// Base directory.
	$baseDir = realpath(__DIR__.'/..');

	// We're relying on Composer's autoloading.
	require $baseDir.'/vendor/autoload.php';

	// If we've got a precompiled code bundle available, load it here.
	if(file_exists($compiled = $baseDir.'/instance/compiled.php')) require $compiled;

	// Initialize the Kernel and handle the Request.
	$app = require_once $baseDir.'/instance/__init.php';
	$app->run();