@extends('layouts.master')
@section('content')
<section id="entries">
	<h2>Entries ({{ $submissions->count() }} in total)</h2>
	<ul class="editions">
@if($edition->categories->count() > 1)
	@foreach($edition->categories as $entry)
		@if($entry->id === $category->id)
		<li><b>{{ $entry->title }}</b></li>
		@else
		<li><a href="{{ $entry->uri() }}">{{ $entry->title }}</a></li>
		@endif
	@endforeach
@endif
	</ul>
@foreach($submissions as $entry)
		<article class="entry">
			<a href="{{ $entry->uri() }}">
				<img src="/games/{{ $entry->slug }}/__small.jpg" alt="{{ $entry->title }}" />
				<h3>{{ $entry->title }}</h3>
				<span>{{ $entry->user->getFullName() }}</span>
			</a>
		</article>
@endforeach
	</section>
@stop