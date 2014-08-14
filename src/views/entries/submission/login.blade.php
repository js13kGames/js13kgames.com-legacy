@extends('layouts.master')
@section('content')
<section id="submit">
	<h2>Please log in</h2>
	<p style="text-align: center">
		In order to submit your game you need to <a href="/account/social/login/github">log in via GitHub</a> and give Js13kGames the requested access rights
		to your repositories.
	</p>
	<p style="text-align: center">
		The game being submitted must be a repository on your personal account on GitHub (ie. not an organization)
		and the zipped master branch of the repository must not exceed 13 kilobytes.
	</p>
</section>
@stop