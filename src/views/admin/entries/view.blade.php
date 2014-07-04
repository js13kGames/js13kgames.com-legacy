@extends('admin/layouts/master')

@section('structure')

<article class="single-entry">
	<h2>
		<a href="{{ $entry->uri() }}">{{ $entry->title }}</a><small>
@if(in_array('Server', $entry->getCategories()))
		<a href="{{ $entry->server_url }}" target="_blank" class="launch">
@else
		<a href="/games/{{ $entry->slug }}/index.html" target="_blank" class="launch">
@endif
		<i class="icon-chevron-right"></i> play</a></small>
	</h2>
	<form @if($entry->getUserVote() !== 0) class="fade" @endif method="post">
		<label for="vote"><b>Cast your vote: </b></label>
		<input type="number" id="vote" min="1" max="100" name="value" maxlength="50" value="{{ $entry->getUserVote() }}" required />
		<input type="submit" class="btn" id="submit" name="submit" class="submit" value="Do eet!" />
	</form>
	<hr />
	<img src="/games/{{ $entry->slug }}/__big.jpg" alt="{{ $entry->title }}" />
	<strong>Author: <a href="mailto:{{ $entry->email }}">{{ $entry->author }}</a></strong><br />
	<strong>Categories: {{ strtolower(implode(', ', $entry->getCategories())) }}</strong>
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
	<div class="description">
		{{ Str::p($entry->description) }}
	</div>
	<hr />
	<div class="votes">
		<h3>{{ $entry->votes->count() }} votes (score: {{ $entry->score }}%)</h3>
		<ul>
@foreach($entry->votes as $vote)
			<li>{{ $vote->user->name }} {{ $vote->user->surname }} - <b>{{ $vote->value }}</b>%</li>
@endforeach
		</ul>
</article>
@stop