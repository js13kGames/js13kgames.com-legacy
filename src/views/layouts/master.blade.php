<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>{{ $title or 'js13kGames - HTML5 and JavaScript Game Development Competition in just 13 kilobytes' }}</title>
	<meta name="author" content="end3r">
	<link rel="shortcut icon" href="/assets/img/favicon.png">
	<link rel="stylesheet" href="/assets/css/style.css">
	<meta name="description" content="Js13kGames is a JavaScript coding competition for HTML5 game developers. The fun part of the compo is the file size limit set to 13 kilobytes. The main theme for 2013 is bad luck, though it is not mandatory." />
	<meta property="og:image" content="http://js13kgames.com/assets/img/banner.png" />
	<meta property="og:url" content="http://js13kgames.com" />
	<meta property="og:title" content="js13kGames - HTML5 and JavaScript Game Development Competition in just 13 kilobytes" />
	<meta property="og:description" content="Js13kGames is a JavaScript coding competition for HTML5 game developers. The fun part of the compo is the file size limit set to 13 kilobytes. The main theme for 2013 is bad luck, though it is not mandatory."/>
</head>
<body>
<header>
	<nav>
		<a class="logo" href="http://js13kgames.com">js13kGames</a>
{{ $menu }}
	</nav>
</header>

<h1>HTML5 and JavaScript Game Development Competition in just 13 kB</h1>

<div class="content">
@yield('content')
</div>

<footer>
	<div>
		&copy; js13kGames 2012-2014.
		<p>Created and maintained by <a target="_blank" href="http://twitter.com/end3r">Andrzej Mazur</a> from <a target="_blank" href="http://enclavegames.com/">Enclave Games</a>.</p>
	</div>
</footer>

<script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
<script type="text/javascript">
	var _gaq = _gaq || [];
	_gaq.push(['_setAccount', 'UA-33368200-1']);
	_gaq.push(['_trackPageview']);
	(function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	})();
</script>

</body>
</html>