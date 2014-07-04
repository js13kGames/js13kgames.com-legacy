@extends('admin/layouts/master')

@section('structure')

<h3>{{ $category->title }} submissions ({{ $submissions->count() }}) for the {{ $edition->title }} edition.</h3>

<ul class="categories">
@if(0 === $category->id)
	<li><b>All</b></li>
@else
	<li><a href="/admin">All</a></li>
@endif
@foreach($categories as $entry)

	@if($entry->id === $category->id)
	<li><b>{{ $entry->title }}</b></li>
	@else
	<li><a href="/admin/{{ $entry->id }}">{{ $entry->title }}</a></li>
	@endif

@endforeach
</ul>

@if($category->id)
<ol class="entries">
@else
<ul class="entries">
@endif

@foreach($submissions as $entry)
	@if(isset($votes[$entry->id]))
	<li class="voted">
	@else
	<li>
	@endif
		<a href="/admin/{{ $entry->slug }}">{{ $entry->title }}</a>
	@if (Auth::user()->level > 10 and !$entry->active)
		<span class="btn-group right">
			<a class="btn btn-small btn-success" href="/admin/accept/{{ $entry->slug }}"><i class="icon-ok"></i></a>
			<a class="btn btn-small btn-danger" href="/admin/reject/{{ $entry->slug }}"><i class="icon-warning-sign"></i></a>
		</span>
	@endif
	@if (Auth::user()->level > 9000)
		<span class="right">
			<a href="https://twitter.com/share" class="twitter-share-button" data-url="http://js13kgames.com{{ $entry->uri() }}/" data-text="Check out {{ $entry->title }} - 13kb entry by @if($entry->twitter)@{{ $entry->twitter }}@else{{ $entry->author }}@endif for the @js13kGames compo!" data-count="horizontal">Tweet</a>
			<iframe src="http://www.facebook.com/plugins/like.php?href=http://js13kgames.com{{ $entry->uri() }}/&amp;send=false&amp;layout=button_count&amp;width=110&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font=segoe+ui&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:130px; height:21px;" allowTransparency="true"></iframe>
			<g:plusone size="medium" href="http://js13kgames.com{{ $entry->uri() }}/"></g:plusone>
		</span>
	@endif
		<small class="right">Avg. score: <b>{{ $entry->score }}%</b> @if(isset($votes[$entry->id])) | Your score: <b>{{$votes[$entry->id]}}%</b> @endif</small>
	</li>
@endforeach
@if($category->id)
	</ol>
@else
	</ul>
@endif
<hr />
@stop