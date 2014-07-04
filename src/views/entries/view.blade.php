<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>{{ $title }}</title>
	<link rel="shortcut icon" href="/img/favicon.png">
	<link rel="stylesheet" href="/style.css?v=v2013">
	<meta property="og:image" content="http://js13kgames.com{{ $entry->uri() }}/__small.jpg"/>
</head>
<body>
<header>
	<nav>
		<a class="logo" href="/">js13kGames</a>
		<ul>
			<li><a href="/entries/">Entries</a></li>
			<li><a href="/#judges">Judges</a></li>
			<li><a href="/#prizes">Prizes</a></li>
			<li><a href="/#rules">Rules</a></li>
			<li><a href="/#contact">Contact</a></li>
			<li><a href="http://2012.js13kgames.com/">2012</a></li>
		</ul>
	</nav>
</header>

<h1>HTML5 and JavaScript Game Development Competition in just 13 kB</h1>

<div class="content">
<article class="single-entry">
	<img src="/games/{{ $entry->slug }}/__big.jpg" alt="{{ $entry->title }}" />
	<div class="info">
		<h2>{{ $entry->title }}</h2>
		<h3>{{ $entry->author }}</h3>
		<ul>
@if($entry->twitter)
			<li class="twitter"><a href="http://twitter.com/{{ $entry->twitter }}">@{{ $entry->twitter }}</a></li>
@endif
@if($entry->website_url)
			<li class="website"><a href="{{ $entry->website_url }}">{{ str_replace(array('http://', 'https://'), '', $entry->website_url) }}</a></li>
@endif
@if($entry->github_url)
			<li class="github"><a href="{{ $entry->github_url }}">{{ str_replace(array('http://', 'https://'), '', $entry->github_url) }}</a></li>
@endif
		</ul>
		<p class="social">
			<a href="https://twitter.com/share" class="twitter-share-button" data-url="http://js13kgames.com{{ $entry->uri() }}/" data-text="Check out {{ $entry->title }} - 13kb entry by @if($entry->twitter)@{{ $entry->twitter }}@else{{ $entry->author }}@endif for the @js13kGames compo!" data-count="horizontal">Tweet</a>
			<iframe src="http://www.facebook.com/plugins/like.php?href=http://js13kgames.com{{ $entry->uri() }}/&amp;send=false&amp;layout=button_count&amp;width=110&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font=segoe+ui&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:130px; height:21px;" allowTransparency="true"></iframe>
			<g:plusone size="medium" href="http://js13kgames.com{{ $entry->uri() }}/"></g:plusone>
		</p>
@if(in_array('Server', $entry->getCategories()))
		<a href="{{ $entry->server_url }}" target="_blank" class="launch">Play the game</a>
@else
		<a href="/games/{{ $entry->slug }}/index.html" target="_blank" class="launch">Play the game</a>
@endif
	</div>
	<div class="description">
		{{ Str::p($entry->description) }}
		<strong>Categories: {{ strtolower(implode(', ', $entry->getCategories())) }}</strong>
	</div>
	<a class="back" href='/entries'>back</a>
</article>
</div>

<footer>
	<div>
		&copy; js13kGames 2013.
		<p>Created and maintained by <a target="_blank" href="http://twitter.com/end3r">Andrzej Mazur</a> from <a target="_blank" href="http://enclavegames.com/">Enclave Games</a>.</p>
	</div>
</footer>

<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
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