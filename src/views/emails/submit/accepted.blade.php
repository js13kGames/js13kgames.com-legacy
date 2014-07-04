<!DOCTYPE html>
<html lang="en-US">
<head>
	<meta charset="utf-8">
</head>
<body>
<h2>Congratulations!</h2>

<div>
	Your submission to the js13kGames contest, <b>{{ $submission->title }}</b>, has been accepted! 
	Your game is now available at <a href="http://js13kgames.com{{ $submission->uri() }}">this link</a>. 
	Go ahead and start promoting it to win bonus prizes!
</div>
</body>
</html>