<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
	<meta charset="utf-8">
	<title>Js13kgames - Judge Dredd's panel</title>
	<link rel="stylesheet" href="{{ url('assets/css/admin.css') }}" />
</head>
<body>
<div class="overlay toolbar">
	<span class="right">Aloha, <b>{{ Auth::user()->name }}</b> <a href="/admin/logout"><i class="icon-user"></i> Logout</a></span>
	<a href="/admin">Entries</a>
</div>
<div id="container">
@yield('structure')
</div>
<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
<script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
</body>
</html>
