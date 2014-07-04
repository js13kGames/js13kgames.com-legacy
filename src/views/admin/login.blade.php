<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
	<meta charset="utf-8">
	<title>Login</title>
	<link rel="stylesheet" href="{{ url('assets/css/login.css') }}" />
</head>
<body>
<form action="/admin/login" method="post" class="login wrap">
	<input type="text" name="email" id="email" placeholder="Email" pattern="^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$"/>
	<input type="password" name="password" id="password" placeholder="Password" />
	<input type="submit" value="Log in" />
</form>
</body>
</html>