@extends('layouts.master')
@section('content')
<article class="single-entry">
	<img src="/games/{{ $entry->slug }}/__big.jpg" alt="{{ $entry->title }}" />
	<div class="info">
		<h2>{{ $entry->title }}</h2>
		<h3>{{ $entry->user->getFullName() }}</h3>
		<ul>
@if($entry->twitter)
			<li class="twitter"><a href="http://twitter.com/{{ $entry->twitter }}">@ {{ $entry->twitter }}</a></li>
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
		{{ js13kgames\utils\Str::p($entry->description) }}
		<strong>Categories: {{ strtolower(implode(', ', $entry->getCategories())) }}</strong>
	</div>
	<a class="back" href='/entries'>back</a>
</article>
@stop