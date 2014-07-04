<?php return new nyx\framework\Kernel([
		'base'    => $baseDir,
		'app'     => $baseDir.'/instance',
		'config'  => $baseDir.'/instance/config',
		'public'  => $baseDir.'/public',
		'src'     => $baseDir.'/src',
		'storage' => $baseDir.'/instance/storage',
	], isset($_SERVER['JS13K_ENV']) ? $_SERVER['JS13K_ENV'] : 'production');